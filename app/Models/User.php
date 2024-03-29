<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
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
        'token',
        'coin_positions',
        'isVerificated',
        'isFirstStart',
        'first_name',
        'last_name',
        'phone',
        'country_code',
        'isOperator',
        'isManager',
    ];

    protected $with = ['ref'];

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
        $access = [
            'admin' => $this->isAdmin,
            'pr' => (bool) $this->team,
            'call' => (bool) $this->isOperator,
            'manager' => (bool) $this->isManager,
        ];

        return $access[$panel->getId()];
    }

    public function session(): HasOne
    {
        return $this->hasOne(Session::class);
    }

    public function convertations(): HasMany
    {
        return $this->hasMany(Convertation::class);
    }

    public function scopeOperators(Builder $query): Builder
    {
        return $query->where('isOperator', true);
    }

    public function scopeManagers(Builder $query): Builder
    {
        return $query->where('isManager', true);
    }

    public function withdraws(): HasMany
    {
        return $this->hasMany(Withdraw::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function servers(): HasMany
    {
        return $this->hasMany(UserServer::class);

//        return $this->belongsToMany(Server::class, 'users_servers')
//            ->with(['possibilities', 'coins', 'media'])
//            ->withPivot([
//                'active_until',
//                'status',
//                'name',
//            ]);
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
        return $this->hasOne(Ref::class, '');
    }

    public function nfts(): BelongsToMany
    {
        return $this->belongsToMany(Nft::class, 'users_nfts');
    }

    public function avatar(): BelongsTo
    {
        return $this->belongsTo(Nft::class, 'avatar_nft_id');
    }

    public function report(): BelongsTo
    {
        return $this->belongsTo(OperatorReport::class);
    }

    public function notifications(): BelongsToMany
    {
        return $this->belongsToMany(Notification::class, 'users_notifications');
    }

    public function notify($notification_id): void
    {
        DB::table('users_notifications')->insert([
            'user_id' => $this->id,
            'notification_id' => $notification_id
        ]);
    }
}

