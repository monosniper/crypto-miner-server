<?php

namespace App\Observers;

use App\Models\Convertation;
use App\Models\UserServer;
use App\Services\CacheService;
use Carbon\Carbon;

class UserServerObserver
{
    public function generateServerName(): string {
        $faker = \Faker\Factory::create();

        $word = ucfirst($faker->word());
        $num = strtoupper($faker->bothify('?## ?? ###'));

        return "$word $num";
    }

    /**
     * Handle the UserServer "created" event.
     */
    public function created(UserServer $userServer): void
    {
        $userServer->name = $this->generateServerName();
        $userServer->active_until = Carbon::now()->addMonth();
        $userServer->save();
    }

    /**
     * Handle the UserServer "updated" event.
     */
    public function updated(UserServer $userServer): void
    {
        $this->cache($userServer);
    }

    /**
     * Handle the UserServer "deleted" event.
     */
    public function deleted(UserServer $userServer): void
    {
        $this->cache($userServer);
    }

    /**
     * Handle the UserServer "restored" event.
     */
    public function restored(UserServer $userServer): void
    {
        //
    }

    /**
     * Handle the UserServer "force deleted" event.
     */
    public function forceDeleted(UserServer $userServer): void
    {
        //
    }

    public function cache(UserServer $userServer): void
    {
        CacheService::saveForUser(CacheService::USER_SERVERS, $userServer->user_id, $userServer->user->servers);
    }
}
