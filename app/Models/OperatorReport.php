<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    const STATUS_CALLED = 'called';
    const STATUS_NOT_CALLED = 'not_called';
    const STATUS_NOT_ACCEPTED = 'not_accepted';

    const REPORT_STATUSES = [
        self::STATUS_CALLED,
        self::STATUS_NOT_CALLED,
        self::STATUS_NOT_ACCEPTED,
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
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

    public function operator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'operator_id');
    }
}
