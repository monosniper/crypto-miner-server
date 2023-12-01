<?php

namespace App\Providers;

use App\Events\SessionStart;
use App\Listeners\ProcessSession;
use App\Models\Ref;
use App\Models\User;
use App\Models\UserServer;
use App\Observers\RefObserver;
use App\Observers\UserObserver;
use App\Observers\UserServerObserver;
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
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
