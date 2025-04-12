<?php

namespace App\Services;

use App\Http\Resources\CoinResource;
use App\Models\Coin;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CoinService
{
    public function getAll(): AnonymousResourceCollection
    {
        return CoinResource::collection(Coin::all());
    }
}
