<?php

namespace App\Models;

use App\Enums\CacheName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Article extends CachableModel implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected CacheName $cacheName = CacheName::ARTICLES;

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
