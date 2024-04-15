<?php

namespace App\Models;

use App\Casts\RateCast;
use App\Enums\OrderMethod;
use App\Enums\OrderPurchaseType;
use App\Enums\OrderStatus;
use App\Enums\OrderType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'type',
        'description',
        'purchase_type',
        'purchase_id',
        'status',
        'checkout_url',
        'method',
        'configuration_id',
    ];

    protected function casts(): array
    {
        return [
            'amount' => RateCast::class,
            'status' => OrderStatus::class,
            'type' => OrderType::class,
            'purchase_type' => OrderPurchaseType::class,
            'method' => OrderMethod::class,
        ];
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', OrderStatus::COMPLETED);
    }

    public function scopeWaiting(Builder $query): Builder
    {
        return $query->where('status', OrderStatus::PENDING);
    }

    public function scopeReplenishments(Builder $query): Builder
    {
        return $query->where('purchase_type', OrderPurchaseType::BALANCE);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
