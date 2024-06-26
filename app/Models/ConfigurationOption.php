<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigurationOption extends Model
{
    protected $fillable = [
        'title',
        'price',
        'field_id',
    ];

    public function field(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ConfigurationField::class);
    }
}
