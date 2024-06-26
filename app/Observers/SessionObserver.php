<?php

namespace App\Observers;

use App\Enums\CacheName;
use App\Enums\ServerStatus;
use App\Models\Notification;
use App\Models\Session;
use App\Services\CacheService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class SessionObserver
{
    public function created(Session $session): void
    {
        CacheService::saveFor(
            CacheName::SESSION,
            $session->id,
            $session
        );

        CacheService::saveFor(
            CacheName::USER,
            $session->user_id,
            single: $session->user_id,
        );

        // Send noty for session end
        $notification = Notification::create([
            'title' => __('notifications.session.start.title'),
        ]);

        $session->user->notify($notification->id);
    }

    public function updated(Session $session): void
    {
        //
    }

    public function deleted(Session $session): void
    {
        $servers = $session->servers;
        $user = $session->user;

//        $total = [
//            'nfts' => 0
//        ];

        foreach ($servers as $server) {
            $log = $server->log;

//            ServerLog::find($server->server_log_id)->delete();

            $server->update([
                'status' => ServerStatus::IDLE,
                'last_work_at' => Carbon::now(),
            ]);

            $nfts = array_map(function ($found) {
                return $found->id;
            }, array_filter($log->founds, function ($found) {
                return $found->type === 'nft';
            }));

//            $total['nfts'] += count($nfts);

            $coins = array_filter($log->founds, function ($found) {
                return $found->type === 'coin';
            });

            $wallet = $user->wallet;
            $balance = $wallet->balance;

            foreach ($coins as $found) {
                $slug = $found->id;

//                if(!$total[$slug]) {
//                    $total[$slug] = 0;
//                }

//                $total[$slug] += $found->amount;
                $balance[$slug] += $found->amount;
            }

            $wallet->balance = $balance;
            $wallet->save();
            $user->nfts()->attach($nfts);
        }

        // Send noty for session end
//        $total_str = "</br>";

//        foreach ($total as $coin => $amount) {
//            $total_str .= strtoupper($coin).": <b>$amount</b></br>";
//        }

        $notification = Notification::create([
            'title' => __('notifications.session.end.title'),
//            'content' => __('notifications.session.end.content') . $total_str
        ]);

        Cache::forget(CacheName::USER->value.'.'.$session->user_id);
        Cache::forget(CacheName::SESSION->value.'.'.$session->id);

        Cache::forget('servers.'.$user->id);
        Cache::put('servers.'.$user->id, $user->servers);

        $session->user->notify($notification->id);
    }
}
