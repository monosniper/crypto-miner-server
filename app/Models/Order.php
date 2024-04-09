<?php

namespace App\Models;

use App\Casts\RateCast;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
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
        'checkout_url',
        'method',
    ];

    protected $casts = [
        'amount' => RateCast::class,
    ];

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

    const CRYPTO = 'crypto';
    const CARD = 'card';

    const METHODS = [
        self::CRYPTO => self::CRYPTO,
        self::CARD => self::CARD,
    ];

    public function scopeCompleted(Builder $query) {
        return $query->where('status', self::COMPLETED);
    }
}
