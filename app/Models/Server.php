<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Server extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title',
        'price',
        'year_price',
        'nft',
        'isHot',
        'possibilities',
    ];

    protected $casts = [
        'possibilities' => 'array'
    ];

    const WORK_STATUS = 'work';
    const ACTIVE_STATUS = 'active';
    const NOT_ACTIVE_STATUS = 'not active';
    const RELOAD_STATUS = 'reload';

    const STATUSES = [
        self::ACTIVE_STATUS, self::WORK_STATUS, self::NOT_ACTIVE_STATUS, self::RELOAD_STATUS,
    ];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('icon')
            ->singleFile();

        $this->addMediaCollection('possibilities');
    }

    public function getIconUrl(): string
    {
        return $this->getFirstMediaUrl('icon');
    }

    public function serverPossibilities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ServerPossibility::class);
    }

    public function possibilities() {
        return Possibility::whereIn('id', $this->serverPossibilities->pluck('id'))->pluck('name');
    }

    public function coins(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(Coin::class, 'server_coins');
    }
}
