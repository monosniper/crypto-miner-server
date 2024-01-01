<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserServer extends Model
{
    use HasFactory;

    protected $table = 'users_servers';

    protected $fillable = [
        'user_id',
        'server_id',
        'active_until',
        'server_log_id',
        'last_work_at',
        'status',
        'name',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function server(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Server::class);
    }

    public function log(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ServerLog::class, 'server_log_id');
    }
}
