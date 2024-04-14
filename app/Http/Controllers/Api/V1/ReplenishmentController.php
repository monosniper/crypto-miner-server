<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\ReplenishmentService;
use Illuminate\Http\JsonResponse;

class ReplenishmentController extends Controller
{
    public function __construct(
        protected ReplenishmentService $service
    ) {}

    public function __invoke(): JsonResponse
    {
        $result = $this->service->getAll();

        return $this->sendResponse($result);
    }
}
