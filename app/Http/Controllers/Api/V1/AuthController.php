<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckPasswordCodeRequest;
use App\Http\Requests\CheckUsernameRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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

    public function verificateMail(string $code): RedirectResponse
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
            'success' => (bool) $user,
            'user_id' => $user?->id
        ];
    }
}
