<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    public function __construct(
        protected NotificationService $service
    ) {}

    public function __invoke(): JsonResponse
    {
        $result = $this->service->getAll();

        return $this->sendResponse($result);
    }
}
