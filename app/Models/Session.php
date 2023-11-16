<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    const STATUS_STOPPED = 'stopped';
    const STATUS_ACTIVE = 'active';

    const STATUSES = [
        self::STATUS_STOPPED,
        self::STATUS_ACTIVE,
    ];

    protected $fillable = [
        'user_id',
        'status',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function coins(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Coin::class, 'sessions_coins');
    }

    public function servers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Server::class, 'sessions_user_servers');
    }

    public function stop(): void
    {
        $this->status = self::STATUS_STOPPED;
        $this->save();
    }
}
