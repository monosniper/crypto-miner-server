<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ref extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'code',
    ];

    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function totalDonates()
    {
        $total = 0;

        foreach ($this->users as $user) {
            $total += $user->orders_sum;
        }

        return $total;
    }

    protected static function booted(): void
    {
        if (auth()->check()) {
            static::addGlobalScope('team', function (Builder $query) {
                $query->whereBelongsTo(auth()->user()->team);
            });
        }
    }
}
