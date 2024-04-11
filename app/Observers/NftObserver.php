<?php

namespace App\Observers;

use App\Models\User;
use App\Services\CacheService;

class NftObserver
{
    public function cache(): void
    {
        foreach (User::all() as $user) {
            CacheService::saveForUser(CacheService::NFTS, $user->id, $user->nfts);
        }
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
