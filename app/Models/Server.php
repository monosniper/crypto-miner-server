<?php

namespace App\Models;

use App\Enums\ServerStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Server extends Model
{
    protected $fillable = [
        'title',
        'status',
        'configuration_id',
        'user_id',
        'server_log_id',
    ];

    protected $casts = [
        'status' => ServerStatus::class
    ];

    public function start(): void
    {
        $this->update([
            'status' => ServerStatus::WORK,
            'server_log_id' => null,
        ]);
    }

    public function configuration(): BelongsTo
    {
        return $this->belongsTo(Configuration::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function log(): BelongsTo
    {
        return $this->belongsTo(ServerLog::class, 'server_log_id');
    }
}
