<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Convertation extends Model
{
    use HasFactory;

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
