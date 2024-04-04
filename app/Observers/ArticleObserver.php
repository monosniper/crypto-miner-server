<?php

namespace App\Observers;

use App\Services\CacheService;

class ArticleObserver
{
    public function updated(): void
    {
        CacheService::save(CacheService::ARTICLES);
    }

    public function created(): void
    {
        CacheService::save(CacheService::ARTICLES);
    }

    public function deleted(): void
    {
        CacheService::save(CacheService::ARTICLES);
    }
}
