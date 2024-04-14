<?php

namespace App\Services;

use App\Enums\CacheName;
use App\Http\Resources\ArticleResource;

class ArticleService extends CachableService
{
    protected string $resource = ArticleResource::class;
    protected CacheName $cacheName = CacheName::ARTICLES;
}
