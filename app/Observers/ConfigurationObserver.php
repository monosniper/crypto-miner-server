<?php

namespace App\Observers;

use App\Services\CacheService;

class ConfigurationObserver
{
    public function updated(): void
    {
        CacheService::save(CacheService::CONFIGURATION);
    }

    public function created(): void
    {
        CacheService::save(CacheService::CONFIGURATION);
    }

    public function deleted(): void
    {
        CacheService::save(CacheService::CONFIGURATION);
    }
}
