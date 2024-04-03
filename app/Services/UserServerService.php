<?php

namespace App\Services;

use App\Http\Resources\UserServerResource;
use App\Models\UserServer;
use Illuminate\Support\Facades\Cache;

class UserServerService
{
    public function getAll(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return UserServerResource::collection(CacheService::getAuth(CacheService::USER_SERVERS));
    }

    public function getOne(string $id): UserServerResource
    {
        return new UserServerResource(CacheService::getSingle(CacheService::USER_SERVERS, $id));
    }
}
