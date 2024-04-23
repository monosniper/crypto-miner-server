<?php

namespace App\Models;

use App\Enums\ReportStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Report extends Model
{
    protected $fillable = [
        'operator_id',
        'status',
    ];

    protected $casts = [
        'status' => ReportStatus::class
    ];

    public function calls(): BelongsToMany
    {
        return $this->belongsToMany(Call::class);
    }

    public function operator(): BelongsTo {
        return $this->belongsTo(User::class, 'operator_id');
    }

    public function statusString(): Attribute
    {
        return Attribute::make(
            get: fn (null $value, array $attributes) => $attributes['status']
        );
    }
}
