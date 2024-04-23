<?php

namespace App\Models;

use App\Enums\CallStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Call extends Model
{
    protected $fillable = [
        'operator_id',
        'user_id',
        'status',
        'comment',
        'amount',
        'isHot',
        'isArchive',
        'isManagerArchive',
    ];

    protected $casts = [
        'status' => CallStatus::class,
    ];

    public function scopeArchive(Builder $query): Builder {
        return $query->where('isManagerArchive', true);
    }

    public function scopeOperatorArchive(Builder $query): Builder {
        return $query->where([
            ['isManagerArchive', false],
            ['isArchive', true],
        ]);
    }

    public function scopeHot(Builder $query): Builder {
        return $query
            ->where('isHot', true)
            ->whereHas('operator');
    }

    public function scopeCold(Builder $query): Builder {
        return $query
            ->where('isHot', false)
            ->whereHas('operator');
    }

    public function scopeNotAnyArchive(Builder $query): Builder {
        return $query->where([
            ['isManagerArchive', false],
            ['isArchive', false],
        ]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'operator_id');
    }

    public function reports(): BelongsToMany
    {
        return $this->belongsToMany(Report::class);
    }

    public function statusString(): Attribute
    {
        return Attribute::make(
            get: fn (null $value, array $attributes) => $attributes['status']
        );
    }
}
