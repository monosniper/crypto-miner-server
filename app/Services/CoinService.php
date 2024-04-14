<?php

namespace App\Services;

use App\Enums\CacheName;
use App\Http\Resources\CoinResource;

class CoinService extends CachableService
{
    protected string $resource = CoinResource::class;
    protected CacheName $cacheName = CacheName::COINS;
}
