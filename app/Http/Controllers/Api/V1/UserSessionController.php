<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\UserSessionService;
use Illuminate\Http\JsonResponse;

class UserSessionController extends Controller
{
    public function __construct(
        protected UserSessionService $service
    ) {}

    public function __invoke(): JsonResponse
    {
        $result = $this->service->getOne(auth()->user()->session?->id);

        return $this->sendResponse($result);
    }
}
