<?php

namespace App\Services;

use App\Enums\CacheName;
use App\Enums\CacheType;
use App\Http\Resources\NftResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserNftService extends CachableService
{
    protected string|AnonymousResourceCollection $resource = NftResource::class;
    protected CacheName $cacheName = CacheName::USER_NFTS;
    protected CacheType $cacheType = CacheType::AUTH;
}
