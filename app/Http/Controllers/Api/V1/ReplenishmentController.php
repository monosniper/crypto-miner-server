<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\ReplenishmentService;

class ReplenishmentController extends Controller
{
    private ReplenishmentService $replenishmentService;

    public function __construct(ReplenishmentService $replenishmentService)
    {
        $this->replenishmentService = $replenishmentService;
    }

    public function __invoke(): \Illuminate\Http\JsonResponse
    {
        $result = $this->replenishmentService->getAll();

        return $this->sendResponse($result);
    }
}
