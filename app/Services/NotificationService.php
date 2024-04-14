<?php

namespace App\Services;

use App\Enums\CacheName;
use App\Enums\CacheType;
use App\Http\Resources\NotificationResource;

class NotificationService extends CachableService
{
    protected string $resource = NotificationResource::class;
    protected CacheName $cacheName = CacheName::NOTIFICATIONS;
    protected CacheType $cacheType = CacheType::AUTH;
}
