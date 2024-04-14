<?php

namespace App\Services;

use App\Enums\CacheName;
use App\Enums\CacheType;
use App\Http\Resources\NftResource;

class UserNftService extends CachableService
{
    protected string $resource = NftResource::class;
    protected CacheName $cacheName = CacheName::USER_NFTS;
    protected CacheType $cacheType = CacheType::AUTH;
}
