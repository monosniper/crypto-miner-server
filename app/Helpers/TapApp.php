<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class TapApp
{
    static public function siteVisited($user_id = null): void
    {
        Http::get(env('TAP_APP_API_URL') . '/site-visited/' . $user_id || auth()->id());
    }

    static public function accountLink($connect, $user_id = null): void
    {
        Http::patch(env('TAP_APP_API_URL') . '/account-link/', [
            'connect' => $connect,
            'hogyx_user_id' => $user_id || auth()->id(),
        ]);
    }
}
