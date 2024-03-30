<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\NFTService;
use Illuminate\Http\JsonResponse;

class NftController extends Controller
{
    private NFTService $nftService;

    public function __construct(NFTService $nftService)
    {
        $this->nftService = $nftService;
    }

    public function __invoke(): JsonResponse
    {
        $result = $this->nftService->getAll();

        return $this->sendResponse($result);
    }
}
