<?php

namespace App\Observers;

use App\Enums\CacheName;
use App\Models\Preset;
use App\Services\CacheService;
use App\Services\ConfigurationService;

class PresetObserver
{
    public function cache(): void
    {
        CacheService::save(CacheName::PRESETS);
    }

    public function created(Preset $preset): void
    {
        $preset->price = ConfigurationService::calculatePrice($preset->configuration);
        $preset->save();
    }

    public function updated(): void
    {
        $this->cache();
    }

    public function deleted(): void
    {
        $this->cache();
    }
}
