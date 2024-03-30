<?php

namespace App\Services;

use App\Http\Resources\CoinResource;
use App\Models\Coin;
use Illuminate\Support\Facades\Cache;

class CoinService
{
    public function getAll(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $items = Cache::rememberForever('coins', fn () => Coin::all());

        return CoinResource::collection($items);
    }
}
