<?php

namespace App\Observers;

use App\Models\Notification;
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
        // Send noty for session end
        $notification = Notification::create([
            'title' => __('notifications.session.start.title'),
        ]);

        $session->user->notify($notification->id);
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

        $total = [
            'nfts' => 0
        ];

        foreach ($servers as $server) {
            $server->update(['status' => Server::ACTIVE_STATUS]);

            $nfts = array_map(function ($found) {
                return $found->id;
            }, array_filter($server->founds, function ($found) {
                return $found->type === 'nft';
            }));

            $total['nfts'] += count($nfts);

            $coins = array_filter($server->founds, function ($found) {
                return $found->type === 'coin';
            });

            $wallet = $user->wallet;
            $balance = $wallet->balance;

            foreach ($coins as $found) {
                $slug = $found->id;

                if(!$total[$slug]) {
                    $total[$slug] = 0;
                }

                $total[$slug] += $found->amount;
                $balance[$slug] += $found->amount;
            }

            $wallet->balance = $balance;
            $wallet->save();
            $user->nfts()->attach($nfts);
        }

        // Send noty for session end
        $total_str = "</br>";

        foreach ($total as $coin => $amount) {
            $total_str .= strtoupper($coin).": <b>$amount</b></br>";
        }

        $notification = Notification::create([
            'title' => __('notifications.session.end.title'),
            'content' => __('notifications.session.end.content') . $total_str
        ]);

        $session->user->notify($notification->id);
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
