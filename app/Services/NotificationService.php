<?php

namespace App\Services;

use App\Http\Resources\NotificationResource;

class NotificationService
{
    public function getAll(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return NotificationResource::collection(CacheService::getAuth(CacheService::NOTIFICATIONS));
    }
}
