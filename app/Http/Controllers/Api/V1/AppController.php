<?php

namespace App\Http\Controllers\Api\V1;

use anlutro\LaravelSettings\Facades\Setting;
use App\Enums\CacheName;
use App\Http\Controllers\Controller;
use App\Models\Coin;
use App\Services\CacheService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AppController extends Controller
{

    public function geo(): JsonResponse
    {
        $result = CacheService::get(CacheName::GEO);

        return $this->sendResponse($result);
    }

    public function settings()
    {
        return Setting::all();
    }
}
