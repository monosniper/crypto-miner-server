<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;

class NotificationController extends Controller
{
    private NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function __invoke(): \Illuminate\Http\JsonResponse
    {
        $result = $this->notificationService->getAll();

        return $this->sendResponse($result);
    }
}
