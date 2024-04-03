<?php

namespace App\Services;

use App\Http\Resources\SessionResource;

class UserSessionService
{
    public function get(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return SessionResource::collection(CacheService::getAuth(CacheService::SESSION));
    }
}
