<?php

namespace App\Observers;

use App\Enums\CacheName;
use App\Services\CacheService;

class ConfigurationGroupObserver
{
    public function cache(): void
    {
        CacheService::save(CacheName::CONFIGURATION);
    }

    public function updated(): void
    {
        $this->cache();
    }

    public function created(): void
    {
        $this->cache();
    }

    public function deleted(): void
    {
        $this->cache();
    }
}
