<?php

namespace App\Observers;

use App\Models\Coin;
use App\Models\Ref;
use App\Models\User;
use App\Models\Wallet;

class UserObserver
{
    protected function addRef($user_id): void
    {
        Ref::create(['user_id' => $user_id]);
    }

    protected function addWallet($user_id): void
    {
        $coins = Coin::all()->pluck('slug');
        $array = [];

        foreach ($coins as $coin) {
            $array[$coin] = 0;
        }

        Wallet::create([
            'user_id' => $user_id,
            'balance' => $array
        ]);
    }

    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $this->addRef($user->id);
        $this->addWallet($user->id);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
