<?php

namespace App\Services;

use App\Enums\CacheName;
use App\Http\Resources\ServerResource;

class ServerService extends CachableService
{
    protected string $resource = ServerResource::class;
    protected CacheName $cacheName = CacheName::SERVERS;
}
