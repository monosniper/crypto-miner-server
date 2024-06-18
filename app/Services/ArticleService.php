<?php

namespace App\Services;

use App\Enums\CacheName;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ArticleService extends CachableService
{
    protected string|AnonymousResourceCollection $resource = ArticleResource::class;
    protected CacheName $cacheName = CacheName::ARTICLES;

    public function update(Article $article): bool
    {
        return $article->increment('views');
    }
}
