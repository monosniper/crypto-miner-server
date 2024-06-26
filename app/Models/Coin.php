<?php

namespace App\Models;

use App\Enums\CacheName;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Coin extends CachableModel implements HasMedia
{
    use InteractsWithMedia;

    protected CacheName $cacheName = CacheName::COINS;

    protected $fillable = [
        'name',
        'slug',
        'rate',
        'change',
        'graph',
        'hardLoad',
    ];

//    protected $with = ['media'];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('image')
            ->singleFile();
    }

    public function getIconUrl(): string
    {
        return $this->getFirstMediaUrl('image');
    }
}
