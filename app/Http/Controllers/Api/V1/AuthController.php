<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckPasswordCodeRequest;
use App\Http\Requests\CheckUsernameRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
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
use App\Services\CacheService;
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
    public function __construct(
        protected AuthService $service
    ) {}

    public function sendVerificationMail(): JsonResponse
    {
        $result = $this->service->sendVerificationMail();

        return $this->sendResponse($result);
    }

    public function register(RegisterUserRequest $request): JsonResponse
    {
        $result = $this->service->register($request->validated());

        return $this->sendResponse($result);
    }

    public function verificateMail(string $code): \Illuminate\Http\RedirectResponse
    {
        return $this->service->verificateMail($code);
    }

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $result = $this->service->forgotPassword($request->validated());

        return $this->sendResponse($result);
    }

    public function updatePassword(UpdatePasswordRequest $request): JsonResponse
    {
        $result = $this->service->updatePassword($request->validated());

        return $this->sendResponse($result);
    }

    public function checkPasswordCode(CheckPasswordCodeRequest $request): JsonResponse
    {
        $result = $this->service->checkPasswordCode();

        return $this->sendResponse($result);
    }

    public function checkUsername(CheckUsernameRequest $request): JsonResponse
    {
        $result = $this->service->checkUsername();

        return $this->sendResponse($result);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->service->login($request->validated());

        return $this->sendResponse($result);
    }

    public function checkToken(Request $request): array
    {
        $user = User::where('token', $request->token)->first();

        return [
            'success' => (bool)$user,
            'user_id' => $user?->id
        ];
    }
}
