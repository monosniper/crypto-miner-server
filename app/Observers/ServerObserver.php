<?php

namespace App\Observers;
use App\Enums\CacheName;
use App\Models\Server;
use App\Services\CacheService;
use Faker\Factory;

class ServerObserver
{
    public function generateServerName(): string {
        $faker = Factory::create();

        $word = ucfirst($faker->word());
        $num = strtoupper($faker->bothify('?## ?? ###'));

        return "$word $num";
    }

    public function cache(Server $server): void
    {
        CacheService::saveForUser(
            CacheName::SERVERS,
            $server->user_id,
            $server
        );
    }

    public function updated(Server $server): void
    {
        $this->cache($server);
    }

    public function created(Server $server): void
    {
        $server->title = $this->generateServerName();
        $server->save();
    }

    public function deleted(Server $server): void
    {
        $this->cache($server);
    }
}
