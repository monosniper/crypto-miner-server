<?php

namespace App\Observers;

use App\Enums\CacheName;
use App\Models\Convertation;
use App\Services\CacheService;

class ConvertationObserver
{
    public function cache(Convertation $convertation): void
    {
        CacheService::saveForUser(
            CacheName::CONVERTATIONS,
            $convertation->user_id,
            $convertation->user->convertations
        );
    }

    public function updated(Convertation $convertation): void
    {
        $this->cache($convertation);
    }

    public function created(Convertation $convertation): void
    {
        $this->cache($convertation);

        CacheService::saveForUser(
            CacheName::WALLET,
            $convertation->user_id,
        );
    }

    public function deleted(Convertation $convertation): void
    {
        $this->cache($convertation);
    }
}
