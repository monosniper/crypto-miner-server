<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigurationOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'price',
        'field_id',
    ];
}
