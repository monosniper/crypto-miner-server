<?php

namespace App\Services;

use App\Enums\CacheName;
use App\Http\Resources\NftResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NFTService extends CachableService
{
    protected string|AnonymousResourceCollection $resource = NftResource::class;
    protected CacheName $cacheName = CacheName::NFTS;
}
