<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Preset extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'configuration',
        'isHot',
        'canFarmNft',
        'price',
    ];

    protected $casts = [
        'configuration' => 'array'
    ];

    public function coins(): BelongsToMany
    {
        return $this->belongsToMany(Coin::class, 'preset_coin');
    }
}
