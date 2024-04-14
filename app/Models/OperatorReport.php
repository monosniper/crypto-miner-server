<?php

namespace App\Models;

use App\Enums\Report;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OperatorReport extends Model
{
    use HasFactory;

    protected $table = 'operators_reports';

    protected $fillable = [
        'operator_id',
        'user_id',
        'status',
        'comment',
        'amount',
        'isHot',
        'isArchive',
    ];

    protected function casts(): array
    {
        return [
            'status' => Report::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeHot(Builder $query): Builder
    {
        return $query->where([
            ['isHot', true],
            ['isArchive', false],
        ]);
    }

    public function scopeCold(Builder $query): Builder
    {
        return $query->where([
            ['isHot', false],
            ['isArchive', false],
        ]);
    }

    public function scopeArchive(Builder $query): Builder
    {
        return $query->where('isArchive', true);
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'operator_id');
    }
}
