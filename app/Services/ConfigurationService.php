<?php

namespace App\Services;

use App\Http\Resources\ConfigurationResource;

class ConfigurationService
{
    public function get(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ConfigurationResource::collection(CacheService::get(CacheService::CONFIGURATION));
    }
}
