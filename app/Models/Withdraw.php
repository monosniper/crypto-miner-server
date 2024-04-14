<?php

namespace App\Models;

use App\Casts\RateCast;
use App\Enums\WithdrawStatus;
use App\Enums\WithdrawType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Withdraw extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nft_id',
        'wallet',
        'amount',
        'status',
        'type',
    ];

    protected function casts(): array
    {
        return [
            'amount' => RateCast::class,
            'status' => WithdrawStatus::class,
            'type' => WithdrawType::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function nft(): BelongsTo
    {
        return $this->belongsTo(Nft::class);
    }
}
