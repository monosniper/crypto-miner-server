<?php

namespace App\Observers;

use App\Models\Preset;
use App\Services\CacheService;
use App\Services\ConfigurationService;

class PresetObserver
{
    /**
     * Handle the Preset "created" event.
     */
    public function created(Preset $preset): void
    {
        $preset->price = ConfigurationService::calculatePrice($preset->configuration);
        $preset->save();
    }

    /**
     * Handle the Preset "updated" event.
     */
    public function updated(): void
    {
        CacheService::save(CacheService::PRESETS);
    }

    /**
     * Handle the Preset "deleted" event.
     */
    public function deleted(): void
    {
        CacheService::save(CacheService::PRESETS);
    }
}
