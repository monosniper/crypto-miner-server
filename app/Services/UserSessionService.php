<?php

namespace App\Services;

use App\Enums\CacheName;
use App\Enums\CacheType;
use App\Http\Resources\SessionResource;

class UserSessionService extends CachableService
{
    protected string $resource = SessionResource::class;
    protected CacheName $cacheName = CacheName::SESSION;
    protected CacheType $cacheType = CacheType::AUTH;
}
