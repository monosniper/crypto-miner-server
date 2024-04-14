<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\CoinService;
use Illuminate\Http\JsonResponse;

class CoinController extends Controller
{
    public function __construct(
        protected CoinService $service
    ) {}

    public function __invoke(): JsonResponse
    {
        $result = $this->service->getAll();

        return $this->sendResponse($result);
    }
}
