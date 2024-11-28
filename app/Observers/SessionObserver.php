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
        $session = Session::with('servers')->find($session->id);

        foreach ($session->servers as $server) {
            info('id: ' . $server->id);
            $server->start();
        }

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
        $user = $session->user;
        $wallet = $user->wallet;
        $balance = $wallet->balance;

        foreach ($session->servers as $server) {
            $server->stop();
        }

        $logs = $session->logs;

        $nfts = array_map(function ($found) {
            return $found->id;
        }, array_filter($logs->founds, function ($found) {
            return $found->type === 'nft';
        }));

        $coins = array_filter($logs->founds, function ($found) {
            return $found->type === 'coin';
        });

        foreach ($coins as $found) {
            $slug = $found->id;
            $balance[$slug] += $found->amount;
        }

        $user->nfts()->attach($nfts);

//        foreach ($session->servers as $server) {
//            $log = $server->log;
//
//            $nfts = array_map(function ($found) {
//                return $found->id;
//            }, array_filter($log->founds, function ($found) {
//                return $found->type === 'nft';
//            }));
//
//            $coins = array_filter($log->founds, function ($found) {
//                return $found->type === 'coin';
//            });
//
//            foreach ($coins as $found) {
//                $slug = $found->id;
//                $balance[$slug] += $found->amount;
//            }
//
//            $user->nfts()->attach($nfts);
//        }

        $wallet->balance = $balance;
        $wallet->save();

//        Cache::forget(CacheName::USER->value.'.'.$session->user_id);
//        Cache::forget(CacheName::SESSION->value.'.'.$session->id);
//
//        Cache::forget('servers.'.$user->id);
//        Cache::put('servers.'.$user->id, $user->servers);

        $notification = Notification::create([
            'title' => __('notifications.session.end.title'),
        ]);
        $user->notify($notification->id);
    }
}
