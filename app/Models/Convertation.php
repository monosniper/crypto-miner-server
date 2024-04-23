<?php

namespace App\Models;

use App\Enums\CacheName;
use App\Enums\CacheType;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Convertation extends CachableModel
{

    protected CacheName $cacheName = CacheName::CONVERTATIONS;
    protected array $cacheTypes = [
        CacheType::AUTH
    ];

    protected function getCacheValue(): array
    {
        return [
            $this->user_id,
            $this->user->convertations
        ];
    }

    protected $fillable = [
        'user_id',
        'from_id',
        'to_id',
        'amount_from',
        'amount_to',
    ];

    public function from(): BelongsTo
    {
        return $this->belongsTo(Coin::class, 'from_id');
    }

    public function to(): BelongsTo
    {
        return $this->belongsTo(Coin::class, 'to_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
