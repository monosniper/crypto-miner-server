<?php

namespace App\Models;

use App\Enums\ServerStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Server extends Model
{
    protected $fillable = [
        'title',
        'status',
        'configuration_id',
        'user_id',
    ];

    protected $casts = [
        'status' => ServerStatus::class
    ];

    public function configuration(): BelongsTo
    {
        return $this->belongsTo(Configuration::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
