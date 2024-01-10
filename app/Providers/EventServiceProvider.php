<?php

namespace App\Providers;

use App\Events\SessionStart;
use App\Listeners\ProcessSession;
use App\Models\ForgotPasswordCode;
use App\Models\Ref;
use App\Models\Session;
use App\Models\User;
use App\Models\UserServer;
use App\Models\VerificationCode;
use App\Observers\ForgotPasswordObserver;
use App\Observers\RefObserver;
use App\Observers\SessionObserver;
use App\Observers\UserObserver;
use App\Observers\UserServerObserver;
use App\Observers\VerificationCodeObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        Ref::observe(RefObserver::class);
        UserServer::observe(UserServerObserver::class);
        ForgotPasswordCode::observe(ForgotPasswordObserver::class);
        VerificationCode::observe(VerificationCodeObserver::class);
        Session::observe(SessionObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
