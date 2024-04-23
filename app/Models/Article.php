<?php

namespace App\Models;

use App\Enums\CacheName;
use App\Enums\CacheType;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Article extends CachableModel implements HasMedia
{
    use InteractsWithMedia;

    protected CacheName $cacheName = CacheName::ARTICLES;
    protected array $cacheTypes = [
        CacheType::DEFAULT,
        CacheType::SINGLE,
    ];

    protected $fillable = [
        'title',
        'content',
    ];

    protected $with = ['media'];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('image')
            ->singleFile();
    }

    public function getImageUrl(): string
    {
        return $this->getFirstMediaUrl('image');
    }
}
