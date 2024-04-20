<?php

namespace App\Services;

use App\Enums\CacheName;
use App\Http\Resources\CoinResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CoinService extends CachableService
{
    protected string|AnonymousResourceCollection $resource = CoinResource::class;
    protected CacheName $cacheName = CacheName::COINS;
}
