<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
    ];

    public function members(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalRefsCount() {
        $ref_ids = $this->members->pluck('ref.id');
        $users = User::whereIn('ref_id', $ref_ids)->get();

        return $users->count();
    }

    public function totalDonates() {
        $ref_ids = $this->members->pluck('ref.id');
        $users = User::whereIn('ref_id', $ref_ids)->get();

        $total = 0;

        foreach ($users as $user) {
            $total += $user->donates->sum('amount');
        }

        return $total;
    }

    public function getIncome() {
        return ($this->totalDonates() / 100) * setting('pr_percent');
    }
}
