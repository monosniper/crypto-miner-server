<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\UserNftService;

class UserNftController extends Controller
{
    private UserNftService $userNftService;

    public function __construct(UserNftService $userNftService)
    {
        $this->userNftService = $userNftService;
    }

    public function __invoke(): \Illuminate\Http\JsonResponse
    {
        $result = $this->userNftService->getAll();

        return $this->sendResponse($result);
    }
}
