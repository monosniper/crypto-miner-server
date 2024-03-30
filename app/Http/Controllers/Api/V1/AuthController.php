<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckPasswordCodeRequest;
use App\Http\Requests\CheckUsernameRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UpdatePasswordRequest;
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
use App\Mail\ForgotPassword;
use App\Mail\Verification;
use App\Models\Coin;
use App\Models\Convertation;
use App\Models\ForgotPasswordCode;
use App\Models\Ref;
use App\Models\Server;
use App\Models\ServerLog;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserServer;
use App\Models\VerificationCode;
use App\Services\AuthService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function sendVerificationMail(): JsonResponse
    {
        $result = $this->authService->sendVerificationMail();

        return $this->sendResponse($result);
    }

    public function register(RegisterUserRequest $request): array
    {
        $user = User::create($request->validated());

        $basic  = new \Vonage\Client\Credentials\Basic(env("VONAGE_KEY"), env("VONAGE_SECRET"));
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS($request->phone, env('APP_NAME'), 'Your verification code: 123456')
        );

        $message = $response->current();

        if ($message->getStatus() == 0) {
            info("The message was sent successfully");
        } else {
            info("The message failed with status: " . $message->getStatus());
        }

//        $code = VerificationCode::create([
//            'user_id' => $user->id,
//        ]);
//        Mail::to($user)->send(new Verification($code->value));

        if($request->ref_code) {
            $user->update([
                'ref_id' => Ref::where('code', $request->ref_code)->first()->id
            ]);
        }

        return ['success' => !!$user];
    }

    public function verificateMail(string $code): \Illuminate\Http\RedirectResponse
    {
        return $this->authService->verificateMail($code);
    }

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $result = $this->authService->forgotPassword($request->validated());

        return $this->sendResponse($result);
    }

    public function updatePassword(UpdatePasswordRequest $request): JsonResponse
    {
        $result = $this->authService->updatePassword($request->validated());

        return $this->sendResponse($result);
    }

    public function checkPasswordCode(CheckPasswordCodeRequest $request): JsonResponse
    {
        $result = $this->authService->checkPasswordCode($request->validated());

        return $this->sendResponse($result);
    }

    public function checkUsername(CheckUsernameRequest $request): JsonResponse
    {
        $result = $this->authService->checkUsername($request->validated());

        return $this->sendResponse($result);
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

    public function nfts(): JsonResponse
    {
        $result = $this->authService->nfts();

        return $this->sendResponse($result);
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
        $servers = Cache::remember('servers.'.auth()->id(), 86400, function () {
            return auth()->user()->servers->load('server');
        });
        return UserServerResource::collection($servers);
    }

    public function server($id): UserServerResource
    {
        return Cache::remember('all.servers.'.$id, 86400, function () use($id) {
            return new UserServerResource(UserServer::find($id)->load('log'));
        });
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
