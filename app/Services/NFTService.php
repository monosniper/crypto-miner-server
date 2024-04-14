<?php

namespace App\Services;

use App\Enums\CacheName;
use App\Http\Resources\NftResource;

class NFTService extends CachableService
{
    protected string $resource = NftResource::class;
    protected CacheName $cacheName = CacheName::NFTS;
}
