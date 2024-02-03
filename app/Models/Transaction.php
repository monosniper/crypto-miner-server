<?php

namespace App\Models;

use App\Casts\RateCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'type',
        'description',
        'purchase_type',
        'purchase_id',
        'status',
    ];

    protected $casts = [
        'amount' => RateCast::class,
    ];

    public function scopeCompleted(Builder $query): void
    {
        $query->where('status', self::COMPLETED);
    }

    public function scopeWaiting(Builder $query): void
    {
        $query->where('status', self::PENDING);
    }

    public function scopeReplenishments(Builder $query): void
    {
        $query->where('purchase_type', self::BALANCE);
    }

    const DONATE = 'donate';
    const PURCHASE = 'purchase';

    const TYPES = [
        self::DONATE => self::DONATE,
        self::PURCHASE => self::PURCHASE,
    ];

    const RENEW_SERVER = 'renew_server';
    const SERVER = 'server';
    const BALANCE = 'balance';

    const COMPLETED = 'finished';
    const FAILED = 'failed';
    const PENDING = 'waiting';

    const PURCHASE_TYPES = [
        self::SERVER => self::SERVER,
        self::BALANCE => self::BALANCE,
    ];

    const STATUSES = [
        self::COMPLETED => self::COMPLETED,
        self::FAILED => self::FAILED,
        self::PENDING => self::PENDING,
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
