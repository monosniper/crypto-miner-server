<?php

namespace App\Observers;

use App\Models\Wallet;
use App\Services\CacheService;

class WalletObserver
{
    public function updated(Wallet $wallet): void
    {
        CacheService::saveForUser(CacheService::WALLET, $wallet->user_id, $wallet);
    }
}
