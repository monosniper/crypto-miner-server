<?php

namespace App\Observers;

use App\Models\Coin;
use App\Models\Ref;
use App\Models\User;
use App\Models\Wallet;
use App\Services\CacheService;
use Stevebauman\Location\Facades\Location;

class UserObserver
{
    protected function generateToken(): string
    {
        return md5(microtime() . 'salt' . time());
    }

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
        $location = Location::get();
        $this->addRef($user->id);
        $this->addWallet($user->id);
        $user->update([
            'token' => $this->generateToken(),
            'country_code' => $location->countryCode,
            'city' => $location->cityName,
        ]);

        CacheService::saveFor(CacheService::USER, $user->id, $user);
        // TODO: in queue
        CacheService::save(CacheService::GEO);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        CacheService::saveFor(CacheService::USER, $user->id, $user);
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
