<?php

namespace App\Http\Controllers\Api\V1;

use anlutro\LaravelSettings\Facades\Setting;
use App\Enums\CacheName;
use App\Http\Controllers\Controller;
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
//        Setting::set('telegram', 'https://www.google.com');
//        Setting::set('youtube', 'https://www.google.com');
//        Setting::set('facebook', 'https://www.google.com');
//        Setting::set('instagram', 'https://www.google.com');
//        Setting::set('tiktok', 'https://www.google.com');
//        Setting::set('withdraw_fee', 30);
//        Setting::set('convertation_fee', 1);
//        Setting::set('ref_percent', 10);
//        Setting::set('pr_percent', 30);
//        Setting::set('transfer_fee', 5);
//        Setting::set('transfer_min', 10);
//
//        Setting::save();

        return Setting::all();
    }
}
