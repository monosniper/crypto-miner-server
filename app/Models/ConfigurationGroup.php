<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConfigurationGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'priority',
    ];

    protected $with = ['fields'];

    public function fields(): HasMany
    {
        return $this->hasMany(ConfigurationField::class, 'group_id');
    }
}
