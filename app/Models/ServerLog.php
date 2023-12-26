<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServerLog extends Model
{
    use HasFactory;

    protected $table = 'server_logs';

    protected $fillable = [
        'logs',
        'founds',
    ];

    protected function logs(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? (is_array($value) ? $value : json_decode($value)) : [],
            set: fn ($value) => json_encode($value),
        );
    }

    protected function founds(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? (is_array($value) ? $value : json_decode($value)) : [],
            set: fn ($value) => json_encode($value),
        );
    }
}
