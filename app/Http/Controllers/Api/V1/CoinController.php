<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\CoinService;

class CoinController extends Controller
{
    private CoinService $coinService;

    public function __construct(CoinService $coinService)
    {
        $this->coinService = $coinService;
    }

    /**
     * Display a listing of the resource.
     */
    public function __invoke(): \Illuminate\Http\JsonResponse
    {
        $result = $this->coinService->getAll();

        return $this->sendResponse($result);
    }
}
