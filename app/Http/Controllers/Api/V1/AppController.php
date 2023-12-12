<?php

namespace App\Http\Controllers\Api\V1;

use anlutro\LaravelSettings\Facades\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AppController extends Controller
{
    public function settings(): \Illuminate\Http\JsonResponse
    {
//        Setting::set('telegram', 'https://www.google.com');
//        Setting::set('youtube', 'https://www.google.com');
//        Setting::set('facebook', 'https://www.google.com');
//        Setting::set('instagram', 'https://www.google.com');
//        Setting::set('tiktok', 'https://www.google.com');
//        Setting::set('withdraw_fee', 30);

//        Setting::save();

        return response()->json(Cache::remember('settings', 86400, function () {
            return Setting::all();
        }));
    }
}
