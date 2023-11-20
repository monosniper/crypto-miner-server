<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'isAdmin',
        'ref_id',
        'team_id',
        'nft_id',
        'coin_positions',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'coin_positions' => 'array',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return $panel->getId() === 'admin'
            ? $this->isAdmin
            : (bool) $this->team;
    }

    public function convertations(): HasMany
    {
        return $this->hasMany(Convertation::class);
    }

    public function withdraws(): HasMany
    {
        return $this->hasMany(Withdraw::class);
    }

    public function servers(): BelongsToMany
    {
        return $this->belongsToMany(Server::class, 'users_servers')
            ->withPivot([
                'work_started_at',
                'active_until',
                'status',
            ]);
    }

    public function wallet(): hasOne
    {
        return $this->hasOne(Wallet::class);
    }

    public function refUser(): HasOneThrough
    {
        return $this->hasOneThrough(Ref::class, User::class);
    }

    public function refs(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, Ref::class);
    }

    public function donates(): HasMany
    {
        return $this->hasMany(Donate::class);
    }

    public function team(): HasOne
    {
        return $this->hasOne(Team::class);
    }

    public function ref(): HasOne
    {
        return $this->hasOne(Ref::class);
    }

    public function nfts(): BelongsToMany
    {
        return $this->belongsToMany(Nft::class, 'users_nfts');
    }

    public function avatar(): BelongsTo
    {
        return $this->belongsTo(Nft::class, 'avatar_nft_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }
}
