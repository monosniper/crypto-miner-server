<?php

namespace App\Services;

use App\Http\Resources\WalletResource;

class WalletService
{
    public function get(): WalletResource
    {
        return new WalletResource(CacheService::getAuth(CacheService::WALLET));
    }
}
