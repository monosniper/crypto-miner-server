<?php

namespace App\Services;

use App\Enums\CacheName;
use App\Enums\CacheType;
use App\Http\Resources\UserServerResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserServerService extends CachableService
{
    protected string|AnonymousResourceCollection $resource = UserServerResource::class;
    protected CacheName $cacheName = CacheName::USER_SERVERS;
    protected CacheType $cacheType = CacheType::AUTH;
}
