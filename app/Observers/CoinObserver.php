<?php

namespace App\Observers;

use App\Services\CacheService;

class CoinObserver
{
    public function updated(): void
    {
        CacheService::save(CacheService::COINS);
    }

    public function created(): void
    {
        CacheService::save(CacheService::COINS);
    }

    public function deleted(): void
    {
        CacheService::save(CacheService::COINS);
    }
}
