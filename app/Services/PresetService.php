<?php

namespace App\Services;

use App\Enums\CacheName;
use App\Http\Resources\PresetResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PresetService extends CachableService
{
    protected string|AnonymousResourceCollection $resource = PresetResource::class;
    protected CacheName $cacheName = CacheName::PRESETS;
}
