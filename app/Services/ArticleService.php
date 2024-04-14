<?php

namespace App\Services;

use App\Enums\CacheName;
use App\Enums\CacheType;
use App\Http\Resources\ArticleResource;

class ArticleService extends CachableService
{

    protected string $resource = ArticleResource::class;
    protected CacheType $cacheType = CacheType::DEFAULT;
    protected CacheName $cacheName = CacheName::CONVERTATIONS;

}
