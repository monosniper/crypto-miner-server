<?php

namespace App\Observers;

use App\Models\Wallet;
use App\Models\Withdraw;
use App\Services\CacheService;

class WalletObserver
{
    public function cache(Wallet $wallet): void
    {
        CacheService::saveForUser(CacheService::WALLET, $wallet->user_id, $wallet);
    }

    public function updated(Wallet $wallet): void
    {
        $this->cache($wallet);
    }

    public function created(Wallet $wallet): void
    {
        $this->cache($wallet);
    }

    public function deleted(Wallet $wallet): void
    {
        $this->cache($wallet);
    }
}
