<?php

namespace App\Http\Controllers\Api\V1;

use anlutro\LaravelSettings\Facades\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AppController extends Controller
{

    public function geo() {
        $rs = DB::select("
            SELECT country_code, count(country_code) as total FROM users WHERE country_code IS NOT NULL
            GROUP BY country_code ORDER BY total DESC
        ");

        return response()->json($rs);
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
//        Setting::set('partnership', [
//            1 => [
//                'title' => 'hello',
//                'description' => 'world',
//            ],
//            2 => [
//                'title' => 'hello 2',
//                'description' => 'world 2',
//            ],
//        ]);
//
//        Setting::save();

        return Setting::all();
    }
}
