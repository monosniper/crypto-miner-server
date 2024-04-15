<?php

namespace App\Observers;

use App\Enums\CacheName;
use App\Models\Preset;
use App\Services\CacheService;
use App\Services\ConfigurationService;

class PresetObserver
{
    protected function cache(): void
    {
        CacheService::save(CacheName::PRESETS);
    }

    protected function calculatePrice(Preset $preset): void
    {
        $preset->price = ConfigurationService::calculatePrice($preset->configuration);
        $preset->saveQuietly();
    }

    public function created(Preset $preset): void
    {
        $this->calculatePrice($preset);
        $this->cache();
    }

    public function updated(Preset $preset): void
    {
        $this->calculatePrice($preset);
        $this->cache();
    }

    public function deleted(): void
    {
        $this->cache();
    }
}
