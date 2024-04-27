<?php

namespace App\Providers;

use App\Models\Configuration;
use App\Models\ConfigurationField;
use App\Models\ConfigurationGroup;
use App\Models\ConfigurationOption;
use App\Models\ForgotPasswordCode;
use App\Models\Nft;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Preset;
use App\Models\Ref;
use App\Models\Report;
use App\Models\Server;
use App\Models\Session;
use App\Models\User;
use App\Models\UserServer;
use App\Models\VerificationCode;
use App\Models\Wallet;
use App\Models\Withdraw;
use App\Observers\ConfigurationGroupObserver;
use App\Observers\ConfigurationObserver;
use App\Observers\ForgotPasswordObserver;
use App\Observers\NftObserver;
use App\Observers\NotificationObserver;
use App\Observers\OrderObserver;
use App\Observers\PresetObserver;
use App\Observers\RefObserver;
use App\Observers\ReportObserver;
use App\Observers\ServerObserver;
use App\Observers\SessionObserver;
use App\Observers\UserObserver;
use App\Observers\UserServerObserver;
use App\Observers\VerificationCodeObserver;
use App\Observers\WalletObserver;
use App\Observers\WithdrawObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [

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
        Wallet::observe(WalletObserver::class);
        Withdraw::observe(WithdrawObserver::class);
        Notification::observe(NotificationObserver::class);
        Server::observe(ServerObserver::class);
        Order::observe(OrderObserver::class);
        Nft::observe(NftObserver::class);
        Configuration::observe(ConfigurationObserver::class);
        ConfigurationGroup::observe(ConfigurationGroupObserver::class);
        ConfigurationField::observe(ConfigurationGroupObserver::class);
        ConfigurationOption::observe(ConfigurationGroupObserver::class);
        Preset::observe(PresetObserver::class);
        Report::observe(ReportObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
