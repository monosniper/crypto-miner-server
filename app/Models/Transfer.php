<?php

namespace App\Models;

use App\Casts\RateCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_to',
        'amount',
    ];

    protected $casts = [
        'amount' => RateCast::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function userTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_to');
    }
}
