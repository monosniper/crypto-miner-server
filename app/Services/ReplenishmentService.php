<?php

namespace App\Services;

use App\Http\Resources\OrderResource;

class ReplenishmentService
{
    public function getAll(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return OrderResource::collection(CacheService::getAuth(CacheService::REPLENISHMENTS));
    }
}
