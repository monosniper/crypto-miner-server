<?php

namespace App\Services;

use App\Enums\CacheName;
use App\Enums\CacheType;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReplenishmentService extends CachableService
{
    protected string|AnonymousResourceCollection $resource = OrderResource::class;
    protected CacheName $cacheName = CacheName::REPLENISHMENTS;
    protected CacheType $cacheType = CacheType::AUTH;
}
