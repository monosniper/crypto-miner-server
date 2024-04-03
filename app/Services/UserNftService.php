<?php

namespace App\Services;

use App\Http\Resources\NftResource;

class UserNftService
{
    public function getAll(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return NftResource::collection(CacheService::getAuth(CacheService::USER_NFTS));
    }
}
