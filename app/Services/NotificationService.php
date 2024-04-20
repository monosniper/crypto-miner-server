<?php

namespace App\Services;

use App\Enums\CacheName;
use App\Enums\CacheType;
use App\Http\Resources\NotificationResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NotificationService extends CachableService
{
    protected string|AnonymousResourceCollection $resource = NotificationResource::class;
    protected CacheName $cacheName = CacheName::NOTIFICATIONS;
    protected CacheType $cacheType = CacheType::AUTH;
}
