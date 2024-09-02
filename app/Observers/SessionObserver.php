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

        CacheService::saveForUser(
            CacheName::SERVERS,
            $session->user_id,
        );

        $session->servers->update([
            'status' => ServerStatus::WORK,
        ]);

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

        $log = $session->logs;

        $session->servers->update([
            'status' => ServerStatus::IDLE,
            'last_work_at' => Carbon::now(),
        ]);

        $nfts = array_map(function ($found) {
            return $found->id;
        }, array_filter($log->founds, function ($found) {
            return $found->type === 'nft';
        }));

        $coins = array_filter($log->founds, function ($found) {
            return $found->type === 'coin';
        });

        $wallet = $user->wallet;
        $balance = $wallet->balance;

        foreach ($coins as $found) {
            $slug = $found->id;
            $balance[$slug] += $found->amount;
        }

        $wallet->balance = $balance;
        $wallet->save();
        $user->nfts()->attach($nfts);

//        Cache::forget(CacheName::USER->value.'.'.$session->user_id);
//        Cache::forget(CacheName::SESSION->value.'.'.$session->id);
//
//        Cache::forget('servers.'.$user->id);
//        Cache::put('servers.'.$user->id, $user->servers);

        $notification = Notification::create([
            'title' => __('notifications.session.end.title'),
        ]);
        $session->user->notify($notification->id);
    }
}
