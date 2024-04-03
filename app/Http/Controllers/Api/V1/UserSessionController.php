<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\UserSessionService;

class UserSessionController extends Controller
{
    private UserSessionService $userSessionService;

    public function __construct(UserSessionService $userSessionService)
    {
        $this->userSessionService = $userSessionService;
    }

    public function __invoke(): \Illuminate\Http\JsonResponse
    {
        $result = $this->userSessionService->get();

        return $this->sendResponse($result);
    }
}
