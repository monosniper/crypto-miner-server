<?php

namespace App\Observers;

use App\Enums\CacheName;
use App\Models\Transfer;
use App\Services\CacheService;

class TransferObserver
{
    public function cache(Transfer $transfer): void
    {
        CacheService::saveForUser(CacheName::TRANSFERS, $transfer->user_id);
        CacheService::saveForUser(CacheName::TRANSFERS, $transfer->user_to);
    }

    public function created(Transfer $transfer): void
    {
        $this->cache($transfer);

        $wallet = $transfer->user->wallet;
        $balance = $wallet->balance;
        $balance['USDT'] -= $transfer->amount;
        $wallet->balance = $balance;
        $wallet->save();

        $user_wallet = $transfer->user_to->wallet;
        $user_balance = $user_wallet->balance;
        $user_balance['USDT'] += $transfer->amount;
        $user_wallet->balance = $user_balance;
        $user_wallet->save();
    }
}
