<?php

namespace App\Observers;

use App\Models\Configuration;
use App\Services\CacheService;
use App\Services\ConfigurationService;

class ConfigurationObserver
{
    public function updated(): void
    {
        CacheService::save(CacheService::CONFIGURATION);
    }

    public function created(Configuration $configuration): void
    {
        $configuration->price = ConfigurationService::calculatePrice($configuration->value);
        $configuration->save();
    }

    public function deleted(): void
    {
        CacheService::save(CacheService::CONFIGURATION);
    }
}
