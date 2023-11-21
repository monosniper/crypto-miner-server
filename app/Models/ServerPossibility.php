<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServerPossibility extends Model
{
    use HasFactory;

    protected $fillable = [
        'server_id',
        'possibility_id',
    ];

    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class);
    }

    public function possibility(): BelongsTo
    {
        return $this->belongsTo(Possibility::class);
    }
}
