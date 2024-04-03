<?php

namespace App\Services;

use App\Http\Resources\ArticleResource;

class ArticleService
{
    public function getAll(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ArticleResource::collection(CacheService::get(CacheService::ARTICLES));
    }

    public function getOne(string $id): ArticleResource
    {
        return new ArticleResource(CacheService::getSingle(CacheService::ARTICLES, $id));
    }
}
