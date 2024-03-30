<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\UserServerService;
use Illuminate\Http\JsonResponse;

class UserServerController extends Controller
{
    private UserServerService $userServerService;

    public function __construct(UserServerService $userServerService)
    {
        $this->userServerService = $userServerService;
    }

    public function index(): JsonResponse
    {
        $result = $this->userServerService->getAll();

        return $this->sendResponse($result);
    }

    public function show(string $id): JsonResponse
    {
        $result = $this->userServerService->getOne($id);

        return $this->sendResponse($result);
    }
}
