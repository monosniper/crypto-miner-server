<?php

namespace App\Observers;
use App\Models\Server;
use Faker\Factory;

class ServerObserver
{
    public function generateServerName(): string {
        $faker = Factory::create();

        $word = ucfirst($faker->word());
        $num = strtoupper($faker->bothify('?## ?? ###'));

        return "$word $num";
    }

    public function created(Server $server): void
    {
        $server->title = $this->generateServerName();
        $server->save();
    }
}
