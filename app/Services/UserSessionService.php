<?php

namespace App\Services;

use App\Enums\CacheName;
use App\Enums\CacheType;
use App\Http\Resources\SessionResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserSessionService extends CachableService
{
    protected string|AnonymousResourceCollection $resource = SessionResource::class;
    protected CacheName $cacheName = CacheName::SESSION;
    protected CacheType $cacheType = CacheType::AUTH;
}
