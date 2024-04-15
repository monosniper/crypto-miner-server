<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Nft extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'price',
    ];

    protected $with = ['media'];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('image')
            ->singleFile();
    }

    public function getUrl(): string
    {
        return $this->getFirstMediaUrl('image');
    }

    public function users(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, 'users_nfts');
    }
}
