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
        'status',
        'name',
        'logs',
        'founds',
    ];

    protected function logs(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? (is_array($value) ? $value : json_decode($value)) : [],
        );
    }

    protected function founds(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? (is_array($value) ? $value : json_decode($value)) : [],
        );
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function server(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Server::class);
    }
}
