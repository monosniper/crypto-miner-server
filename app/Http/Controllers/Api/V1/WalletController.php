<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\WalletService;

class WalletController extends Controller
{
    private WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    public function __invoke(): \Illuminate\Http\JsonResponse
    {
        $result = $this->walletService->get();

        return $this->sendResponse($result);
    }
}
