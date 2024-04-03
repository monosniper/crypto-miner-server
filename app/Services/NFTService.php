<?php

namespace App\Services;

use App\Http\Resources\NftResource;

class NFTService
{
    public function getAll(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return NftResource::collection(CacheService::get(CacheService::NFTS));
    }
}
