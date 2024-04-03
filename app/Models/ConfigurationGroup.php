<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigurationGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'priority',
    ];

    protected $with = ['fields'];

    public function fields(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ConfigurationField::class, 'group_id');
    }
}
