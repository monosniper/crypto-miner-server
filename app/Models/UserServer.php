<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserServer extends Model
{
    use HasFactory;

    protected $table = 'users_servers';

    protected $fillable = [
        'user_id',
        'server_id',
        'work_started_at',
        'active_until',
        'status',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function server(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Server::class);
    }
}
