<?php

namespace App\Services;

use App\Http\Resources\CoinResource;

class CoinService
{
    public function getAll(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return CoinResource::collection(CacheService::get(CacheService::COINS));
    }
}
