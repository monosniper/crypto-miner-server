<?php

namespace App\Models;

use App\Casts\RateCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'type',
        'description',
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
}
