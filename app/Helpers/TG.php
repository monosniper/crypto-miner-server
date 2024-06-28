<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class TG
{
    static function sendFormatMessage(array $data): void
    {
        $token = config('app.admin_bot_token');
        $admin_ids = config('app.admin_tg_ids');

        $message = "";

        foreach ($data as $key => $value) {
            $message .= "<b>" . $key . ":</b> " . $value . "\n";
        }

        foreach ($admin_ids as $admin_id) {
            Http::withQueryParameters([
                'chat_id' => $admin_id,
                'parse_mode' => 'HTML',
                'text' => $message,
            ])->get("https://api.telegram.org/bot$token/sendMessage");
        }
    }
}
