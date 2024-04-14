<?php

namespace App\Models;

use App\Enums\ConfigurationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConfigurationField extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'priority',
        'group_id',
        'type',
    ];

    protected $with = ['options'];

    protected function casts(): array
    {
        return [
            'type' => ConfigurationType::class,
        ];
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(ConfigurationGroup::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(ConfigurationOption::class, 'field_id');
    }
}
