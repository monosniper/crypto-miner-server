<?php

namespace App\Models;

use App\Casts\RateCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    use HasFactory;

    const TYPE_COIN = 'coin';
    const TYPE_NFT = 'nft';

    const TYPES = [self::TYPE_COIN, self::TYPE_NFT];

    const STATUS_PENDING = 'pending';
    const STATUS_SUCCESS = 'success';
    const STATUS_FAILED = 'failed';

    const STATUSES = [self::STATUS_PENDING, self::STATUS_SUCCESS, self::STATUS_FAILED];

    protected $fillable = [
        'user_id',
        'nft_id',
        'wallet',
        'amount',
        'status',
        'type',
    ];

    protected $casts = [
        'amount' => RateCast::class,
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function nft(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Nft::class);
    }
}
