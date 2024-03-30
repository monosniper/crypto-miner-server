<?php

namespace App\Services;

use App\Http\Resources\ArticleResource;
use App\Models\Article;

class ArticleService
{
    public function getAll(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $articles = Article::latest()->get();

        return ArticleResource::collection($articles);
    }

    public function getOne(Article $article): ArticleResource
    {
        return new ArticleResource($article);
    }
}
