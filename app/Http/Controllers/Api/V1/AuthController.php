<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\ConvertationResource;
use App\Http\Resources\NftResource;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\ServerResource;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserServerResource;
use App\Http\Resources\WalletResource;
use App\Http\Resources\WithdrawResource;
use App\Models\Coin;
use App\Models\Convertation;
use App\Models\Ref;
use App\Models\Server;
use App\Models\ServerLog;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserServer;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request): array
    {
        $user = User::create($request->validated());

        if($request->ref_code) {
            $user->update([
                'ref_id' => Ref::where('code', $request->ref_code)->first()->id
            ]);
        }

        return ['success' => !!$user];
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json(['success' => true]);
        }

        return response()->json([
            'success' => false,
            'errors' => [
                'email' => 'The provided credentials do not match our records.',
            ]
        ]);
    }

    public function storeConvertation(Request $request): array
    {
        $coin_from = Coin::find($request->coin_from_id);
        $coin_to = Coin::find($request->coin_to_id);

        $coef = $coin_from->rate / $coin_to->rate;
        $amount_to = $request->amount * $coef;

        $amount_to -= $amount_to / 100 * setting('comission_fee');

        $convertation = Convertation::create([
            'user_id' => auth()->id(),
            'from_id' => $request->coin_from_id,
            'to_id' => $request->coin_to_id,
            'amount_from' => $request->amount,
            'amount_to' => $amount_to,
        ]);

        $wallet = auth()->user()->wallet;
        $balance = $wallet->balance;

        $balance[$coin_from->slug] -= $request->amount;
        $balance[$coin_to->slug] += $amount_to;

        $wallet->balance = $balance;
        $wallet->save();

        return ['success' => (bool) $convertation];
    }

    public function withdraws(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $withdraws = Auth::user()->withdraws()->latest()->get();
        return WithdrawResource::collection($withdraws);
    }

    public function replenishments(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $replenishments = Auth::user()->transactions()->replenishments()->latest()->get();
        return TransactionResource::collection($replenishments);
    }

    public function storeReplenishment(Request $request): array
    {
        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'type' => Transaction::PURCHASE,
            'description' => __('transactions.replenishment'),
            'purchase_type' => Transaction::BALANCE,
        ]);

        $response = Http::withHeader('x-api-key', env('NOWPAYMENTS_API_KEY'))
            ->post('https://api.nowpayments.io/v1/invoice', [
                "price_amount" => $request->amount,
                "price_currency" => "usd",
                "order_id" => $transaction->id,
                "order_description" => __('transactions.replenishment'),
                "success_url" => env('FRONT_URL') . "?success=true&type=balance",
                "cancel_url" => env('FRONT_URL') . "?success=false",
            ]);

        if($response->ok()) {
            $data = $response->json();

            $transaction->update(['payment_id' => $data['id']]);

            return ['success' => true, 'url' => $data['invoice_url']];
        } else {
            $transaction->delete();

            return ['success' => false, 'error' => 'Server error'];
        }
    }

    public function buyServer(Request $request): array
    {
        $user = auth()->user();
        $server = Server::find($request->server_id);
        $amount = $server->price;

        if($server->type === Server::TYPE_FREE) {
            if($user->servers()->where('server_id',$server->id)->first()) {
                return ['success' => true, 'url' => env('FRONT_URL') . "?success=false&type=server_exists"];
            } else {
                $server_log = ServerLog::create();
                UserServer::create([
                    'user_id' => $user->id,
                    'server_id' => $server->id,
                    'server_log_id' => $server_log->id,
                    'active_until' => Carbon::now()->addYear(),
                ]);

                return ['success' => true, 'url' => env('FRONT_URL') . "?success=true&type=server"];
            }
        } else {
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'type' => Transaction::PURCHASE,
                'description' => __('transactions.buy_server'),
                'purchase_type' => Transaction::SERVER,
                'purchase_id' => $request->server_id,
            ]);

            $response = Http::withHeader('x-api-key', env('NOWPAYMENTS_API_KEY'))
                ->post('https://api.nowpayments.io/v1/invoice', [
                    "price_amount" => $amount,
                    "price_currency" => "usd",
                    "order_id" => $transaction->id,
                    "order_description" => __('transactions.buy_server'),
                    "success_url" => env('FRONT_URL') . "?success=true&type=server",
                    "cancel_url" => env('FRONT_URL') . "?success=false",
                ]);

            info("PAY ".json_encode($response->body()));

            if($response->ok()) {
                $data = $response->json();

                $transaction->update(['payment_id' => $data['id']]);

                return ['success' => true, 'url' => $data['invoice_url']];
            } else {
                $transaction->delete();

                return ['success' => false, 'error' => 'Server error'];
            }
        }
    }

    public function donate(Request $request) {
        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'type' => Transaction::DONATE,
            'description' => __('transactions.donate'),
        ]);

        $response = Http::withHeader('x-api-key', env('NOWPAYMENTS_API_KEY'))
            ->post('https://api.nowpayments.io/v1/invoice', [
                "price_amount" => $request->amount,
                "price_currency" => "usd",
                "order_id" => $transaction->id,
                "order_description" => __('transactions.donate'),
                "success_url" => env('FRONT_URL') . "?success=true&type=donate",
                "cancel_url" => env('FRONT_URL') . "?success=false",
            ]);

        if($response->ok()) {
            $data = $response->json();

            $transaction->update(['payment_id' => $data['id']]);

            return ['success' => true, 'url' => $data['invoice_url']];
        } else {
            $transaction->delete();

            return ['success' => false, 'error' => 'Server error'];
        }
    }

    public function nfts(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $nfts = Auth::user()->nfts;

        return NftResource::collection($nfts);
    }

    public function convertations(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $convertations = Auth::user()->convertations()->latest()->get();
        return ConvertationResource::collection($convertations);
    }

    public function withdraw_nft(): JsonResponse {
        // nft_id

        return response()->json([
            'success' => true
        ]);
    }

    public function update(UpdateUserRequest $request): JsonResponse {
        $user = Auth::user();

        return response()->json(['success' => $user->update($request->validated())]);
    }

    public function me(): UserResource
    {
        return new UserResource(Auth::user());
    }

    public function wallet(): WalletResource
    {
        $wallet = Auth::user()->wallet;

        return new WalletResource($wallet);
    }

    public function servers(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $servers = Auth::user()->servers;

        return UserServerResource::collection($servers);
    }

    public function server($id): UserServerResource
    {
        $server = UserServer::find($id)->load('log');

        return new UserServerResource($server);
    }

    public function invest(): array
    {
        return [
            'url' => 'https://www.google.com'
        ];
    }

    public function checkToken(Request $request): array
    {
        $user = User::where('token', $request->token)->first();

        return [
            'success' => (bool)$user,
            'user_id' => $user?->id
        ];
    }

    public function notifications(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return NotificationResource::collection(auth()->user()->notifications()->latest()->get());
    }
}
