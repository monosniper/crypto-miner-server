<?php

namespace App\Services;

use App\Enums\CacheName;
use App\Enums\CacheType;
use App\Http\Resources\WalletResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class WalletService extends CachableService
{
    protected string|AnonymousResourceCollection $resource = WalletResource::class;
    protected CacheName $cacheName = CacheName::WALLET;
    protected CacheType $cacheType = CacheType::AUTH;
}
