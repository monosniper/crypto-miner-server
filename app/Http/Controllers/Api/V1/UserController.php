<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Services\CacheService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        protected UserService $service,
    ) {}

    public function update(UpdateUserRequest $request): JsonResponse
    {
        $result = $this->service->update($request->validated());

        return $this->sendResponse($result);
    }

    public function me(): JsonResponse
    {
        $result = $this->service->me();

        return $this->sendResponse($result);
    }

    public function ref(): JsonResponse
    {
        $result = $this->service->ref();

        return $this->sendResponse($result);
    }
}
