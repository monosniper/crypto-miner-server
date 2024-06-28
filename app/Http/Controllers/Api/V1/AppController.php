<?php

namespace App\Http\Controllers\Api\V1;

use anlutro\LaravelSettings\Facades\Setting;
use App\Enums\CacheName;
use App\Http\Controllers\Controller;
use App\Http\Resources\PartnerResource;
use App\Models\Coin;
use App\Services\CacheService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AppController extends Controller
{
    public function __construct(
        private readonly CacheService $cacheService,
    ) {}

    public function geo(): JsonResponse
    {
        $result = $this->cacheService->get(CacheName::GEO);

        return $this->sendResponse($result);
    }

    public function settings()
    {
        return Setting::all();
    }

    public function partners(): JsonResponse
    {
        $result = $this->cacheService->get(CacheName::PARTNERS);

        return $this->sendResponse(PartnerResource::collection($result));
    }
}
