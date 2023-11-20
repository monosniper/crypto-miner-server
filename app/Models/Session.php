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
        'logs',
        'founds',
        'current_server_id',
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
        return $this->belongsToMany(Server::class, 'sessions_user_servers', 'session_id', 'user_server_id');
    }

    public function stop(): void
    {
        $this->status = self::STATUS_STOPPED;
        $this->save();
    }

    public function currentServer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Server::class, 'current_server_id');
    }
}
