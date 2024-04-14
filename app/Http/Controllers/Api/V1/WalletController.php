<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\WalletService;
use Illuminate\Http\JsonResponse;

class WalletController extends Controller
{
    public function __construct(
        protected WalletService $service
    ) {}

    public function __invoke(): JsonResponse
    {
        $result = $this->service->getOne();

        return $this->sendResponse($result);
    }
}
