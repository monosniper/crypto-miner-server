<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class TapApp
{
    static public function siteVisited($user_id = null): void
    {
        Http::get(config('app.tap_api') . '/site-visited/' . $user_id || auth()->id());
    }

    static public function accountLink($connect, $user_id = null): void
    {
        Http::patch(config('app.tap_api') . '/account-link/', [
            'connect' => $connect,
            'hogyx_user_id' => $user_id || auth()->id(),
        ]);
    }
}
