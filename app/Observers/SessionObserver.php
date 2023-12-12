<?php

namespace App\Observers;

use App\Models\Server;
use App\Models\Session;
use Illuminate\Support\Facades\Cache;

class SessionObserver
{
    /**
     * Handle the Session "created" event.
     */
    public function created(Session $session): void
    {
        //
    }

    /**
     * Handle the Session "updated" event.
     */
    public function updated(Session $session): void
    {
        //
    }

    /**
     * Handle the Session "deleted" event.
     */
    public function deleted(Session $session): void
    {
        Cache::forget('session.'.$session->user_id);

        $servers = $session->user_servers;
        $user = $session->user;

        foreach ($servers as $server) {
            $server->update(['status' => Server::ACTIVE_STATUS]);

            $nfts = array_map(function ($found) {
                return $found->id;
            }, array_filter($server->founds, function ($found) {
                return $found->type === 'nft';
            }));

            $coins = array_filter($server->founds, function ($found) {
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
        }
    }

    /**
     * Handle the Session "restored" event.
     */
    public function restored(Session $session): void
    {
        //
    }

    /**
     * Handle the Session "force deleted" event.
     */
    public function forceDeleted(Session $session): void
    {
        //
    }
}
