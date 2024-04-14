<?php

namespace App\Services;

use App\Http\Resources\PresetResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PresetService
{
    public function getAll(): AnonymousResourceCollection
    {
        return PresetResource::collection(CacheService::get(CacheService::PRESETS));
    }
}
