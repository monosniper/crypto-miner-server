<?php

namespace App\Observers;

use App\Enums\CacheName;
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

        CacheService::saveFor(CacheName::USER, $user->id, $user);
        CacheService::save(CacheName::GEO);
    }

    public function updated(User $user): void
    {
        CacheService::saveFor(CacheName::USER, $user->id, $user);
    }

    public function deleted(User $user): void
    {
        //
    }
}
