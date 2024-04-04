<?php

namespace App\Observers;

use App\Models\Convertation;
use App\Services\CacheService;

class ConvertationObserver
{
    public function cache(Convertation $convertation): void
    {
        CacheService::saveForUser(CacheService::CONVERTATIONS, $convertation->user_id, $convertation->user->convertations);
    }

    public function updated(Convertation $convertation): void
    {
        $this->cache($convertation);
    }

    public function created(Convertation $convertation): void
    {
        $this->cache($convertation);
    }

    public function deleted(Convertation $convertation): void
    {
        $this->cache($convertation);
    }
}