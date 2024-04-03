<?php

namespace App\Services;

use App\Http\Resources\WalletResource;

class WalletService
{
    public function get(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return WalletResource::collection(CacheService::getAuth(CacheService::WALLET));
    }
}
