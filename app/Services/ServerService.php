<?php

namespace App\Services;

use App\Http\Resources\ServerResource;

class ServerService
{
    public function getAll(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ServerResource::collection(CacheService::get(CacheService::SERVERS));
    }
}
