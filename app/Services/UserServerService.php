<?php

namespace App\Services;

use App\Enums\CacheName;
use App\Enums\CacheType;
use App\Http\Resources\UserServerResource;

class UserServerService extends CachableService
{
    protected string $resource = UserServerResource::class;
    protected CacheName $cacheName = CacheName::USER_SERVERS;
    protected CacheType $cacheType = CacheType::AUTH;
}
