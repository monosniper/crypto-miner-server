<?php

namespace App\Models;

use App\Enums\ServerStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Server extends Model
{
    protected $fillable = [
        'title',
        'status',
        'configuration_id',
        'user_id',
        'last_work_at',
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

    public function stop(): void
    {
        $this->update([
            'status' => ServerStatus::IDLE,
            'last_work_at' => Carbon::now(),
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

    public function coins(): BelongsToMany
    {
        return $this->belongsToMany(Coin::class, 'server_coin');
    }

    public function log(): BelongsTo
    {
        return $this->belongsTo(ServerLog::class, 'server_log_id');
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(Session::class);
    }
}
