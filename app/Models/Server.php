<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Server extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    const TYPE_FREE = 'free';
    const TYPE_STANDARD = 'standard';
    const TYPE_PRO = 'pro';
    const TYPE_PREMIUM = 'premium';
    const TYPE_ELITE = 'elite';
    const TYPE_MAX = 'max';

    const TYPES = [
        self::TYPE_FREE,
        self::TYPE_STANDARD,
        self::TYPE_PRO,
        self::TYPE_PREMIUM,
        self::TYPE_ELITE,
        self::TYPE_MAX,
    ];

    protected $fillable = [
        'title',
        'price',
        'year_price',
        'nft',
        'isHot',
        'type',
    ];

    const WORK_STATUS = 'work';
    const ACTIVE_STATUS = 'active';
    const NOT_ACTIVE_STATUS = 'not active';
    const RELOAD_STATUS = 'reload';

    protected $with = ['media'];

    const STATUSES = [
        self::ACTIVE_STATUS, self::WORK_STATUS, self::NOT_ACTIVE_STATUS, self::RELOAD_STATUS,
    ];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('icon')
            ->singleFile();
    }

    public function getIconUrl(): string
    {
        return $this->getFirstMediaUrl('icon');
    }

    public function possibilities(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Possibility::class, 'server_possibilities');
    }

    public function coins(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Coin::class, 'server_coins');
    }
}
