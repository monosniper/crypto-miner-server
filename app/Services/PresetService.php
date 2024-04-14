<?php

namespace App\Services;

use App\Enums\CacheName;
use App\Http\Resources\PresetResource;

class PresetService extends CachableService
{
    protected string $resource = PresetResource::class;
    protected CacheName $cacheName = CacheName::PRESETS;
}
