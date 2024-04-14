<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\NFTService;
use Illuminate\Http\JsonResponse;

class NftController extends Controller
{
    public function __construct(
        protected NFTService $service
    ) {}

    public function __invoke(): JsonResponse
    {
        $result = $this->service->getAll();

        return $this->sendResponse($result);
    }
}
