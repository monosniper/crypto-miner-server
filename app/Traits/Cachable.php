<?php

namespace App\Traits;

use App\Enums\CacheName;
use App\Enums\CacheType;

trait Cachable
{
    protected string $resource;
    protected CacheName $cacheName = CacheName::NULL;
    protected CacheType $cacheType = CacheType::DEFAULT;
    protected bool $cacheOnCreate = true;
    protected bool $cacheOnUpdate = true;
    protected bool $cacheOnDelete = true;
}
