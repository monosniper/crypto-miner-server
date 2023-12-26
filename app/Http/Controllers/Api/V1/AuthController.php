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
use App\Models\Server;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserServer;
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

    public function withdraws(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $withdraws = Auth::user()->withdraws;
        return WithdrawResource::collection($withdraws);
    }

    public function replenishments(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $replenishments = Auth::user()->transactions()->replenishments()->get();
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

        info($response->body());

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
        $amount = Server::find($request->server_id)->price_month;

        $transaction = Transaction::create([
            'user_id' => auth()->id(),
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

        if($response->ok()) {
            $data = $response->json();

            $transaction->update(['payment_id' => $data['id']]);

            return ['success' => true, 'url' => $data['invoice_url']];
        } else {
            $transaction->delete();

            return ['success' => false, 'error' => 'Server error'];
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
        $convertations = Auth::user()->convertations;
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
        $servers = Cache::remember('user_servers.'.auth()->id(), 86400, function () {
            return Auth::user()->servers;
        });

        return UserServerResource::collection($servers);
    }

    public function server($id): UserServerResource
    {
        $server = UserServer::find($id)->with('log');

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
