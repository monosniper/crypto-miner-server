<?php

namespace App\Models;

use App\Casts\RateCast;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'city',
        'manager_id',
    ];

//    protected $withCount = ['ref.users'];

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
        'orders_sum_amount' => RateCast::class,
    ];

    public function scopeNotArchive(Builder $query): Builder
    {
        return $query->where('isArchive', false);
    }

    public function scopeNotAdmin(Builder $query): Builder
    {
        return $query->where('isAdmin', false);
    }

    public function scopeNotOperator(Builder $query): Builder
    {
        return $query->where('isOperator', false);
    }

    public function scopeNotManager(Builder $query): Builder
    {
        return $query->where('isManager', false);
    }

    public function scopeNotCall(Builder $query): Builder
    {
        return $query->whereDoesntHave(
            'call.operator',
        )->whereDoesntHave(
            'call',
            fn (Builder $query) => $query->where('isManagerArchive', true)
        );
    }

    public function scopeOperators(Builder $query): Builder
    {
        return $query->where('isOperator', true);
    }

    public function scopeActiveManagers(Builder $query): Builder
    {
        return $query->where([
            ['isManagerActive', true],
            ['isManager', true],
        ]);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        $access = [
            'admin' => fn () => $this->isAdmin,
            'pr' => fn () => (bool) $this->team,
            'call' => fn () => (bool) $this->isOperator,
            'manager' => fn () => (bool) $this->isManager,
        ];

        return $access[$panel->getId()]();
    }

    public function session(): HasOne
    {
        return $this->hasOne(Session::class);
    }

    public function convertations(): HasMany
    {
        return $this->hasMany(Convertation::class);
    }

    public function replenishments(): HasMany
    {
        return $this->hasMany(Order::class)->replenishments();
    }

    public function withdraws(): HasMany
    {
        return $this->hasMany(Withdraw::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function servers(): HasMany
    {
        return $this->hasMany(Server::class);
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

    public function report(): HasOne
    {
        return $this->hasOne(OperatorReport::class);
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

    public function fullName(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $attributes['first_name'] . ' ' . $attributes['last_name'],
        );
    }

    public function call(): HasOne
    {
        return $this->hasOne(Call::class);
    }
}

