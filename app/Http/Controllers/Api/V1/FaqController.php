<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\CacheName;
use App\Http\Controllers\Controller;
use App\Services\CacheService;
use Illuminate\Http\JsonResponse;

class FaqController extends Controller
{
    public function __construct(
        private readonly CacheService $cacheService,
    ) {}

    public function __invoke(): JsonResponse
    {
        $result = $this->cacheService->get(CacheName::FAQ);

        return $this->sendResponse(FaqResource::collection($result));
    }
}
