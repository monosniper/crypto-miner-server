<?php

namespace App\Observers;

use App\Enums\CacheName;
use App\Models\Nft;
use App\Services\CacheService;

class NftObserver
{
    public function cache($nft): void
    {
        foreach ($nft->users as $user) {
            CacheService::saveForUser(CacheName::NFTS, $user->id, $user->nfts);
        }
    }

    public function updated(Nft $nft): void
    {
        $this->cache($nft);
    }

    public function deleted(Nft $nft): void
    {
        $this->cache($nft);
    }
}
