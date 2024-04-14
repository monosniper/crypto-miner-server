<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\Configuration as Configuration;

class ConfigurationField extends Model
{
    use HasFactory;

    const SELECT = 'select';
    const TEXT = 'text';
    const COINS = 'coins';
    const COMMENT = 'comment';

    const TYPES = [
        self::SELECT => self::SELECT,
        self::TEXT => self::TEXT,
        self::COINS => self::COINS,
        self::COMMENT => self::COMMENT,
    ];

    protected $fillable = [
        'slug',
        'priority',
        'group_id',
        'type',
    ];

    protected $with = ['options'];

    protected $casts = [
        'type' => Configuration::class
    ];

    public function group(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ConfigurationGroup::class);
    }

    public function options(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ConfigurationOption::class, 'field_id');
    }
}
