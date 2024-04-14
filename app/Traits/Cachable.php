<?php

namespace App\Traits;

use App\Enums\CacheName;
use App\Enums\CacheType;

trait Cachable
{
    protected string $resource;
    protected CacheName $cacheName;
    protected CacheType $cacheType = CacheType::DEFAULT;
}
