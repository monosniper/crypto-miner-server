<?php

namespace App\Services;

use App\Enums\CacheName;
use App\Enums\CacheType;
use App\Http\Resources\OrderResource;

class ReplenishmentService extends CachableService
{
    protected string $resource = OrderResource::class;
    protected CacheName $cacheName = CacheName::REPLENISHMENTS;
    protected CacheType $cacheType = CacheType::AUTH;
}
