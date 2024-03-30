<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function update(UpdateUserRequest $request): JsonResponse
    {
        $result = $this->userService->update($request->validated());

        return $this->sendResponse($result);
    }

    public function me(): JsonResponse
    {
        $result = $this->userService->me();

        return $this->sendResponse($result);
    }
}
