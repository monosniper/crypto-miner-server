<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Session extends Model
{
    protected $fillable = [
        'user_id',
        'logs',
        'end_at',
    ];

    protected function logs(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? (is_array($value) ? $value : json_decode($value)) : [],
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function coins(): BelongsToMany
    {
        return $this->belongsToMany(Coin::class, 'sessions_coins');
    }

    public function servers(): BelongsToMany
    {
        return $this->belongsToMany(Server::class, 'session_server');
    }
}
