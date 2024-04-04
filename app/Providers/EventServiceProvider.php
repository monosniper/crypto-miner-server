<?php

namespace App\Providers;

use App\Events\SessionStart;
use App\Listeners\ProcessSession;
use App\Models\Article;
use App\Models\Coin;
use App\Models\ConfigurationField;
use App\Models\ConfigurationGroup;
use App\Models\ConfigurationOption;
use App\Models\Convertation;
use App\Models\ForgotPasswordCode;
use App\Models\Nft;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Ref;
use App\Models\Server;
use App\Models\Session;
use App\Models\User;
use App\Models\UserServer;
use App\Models\VerificationCode;
use App\Models\Wallet;
use App\Models\Withdraw;
use App\Observers\ArticleObserver;
use App\Observers\CoinObserver;
use App\Observers\ConfigurationObserver;
use App\Observers\ConvertationObserver;
use App\Observers\ForgotPasswordObserver;
use App\Observers\NftObserver;
use App\Observers\NotificationObserver;
use App\Observers\OrderObserver;
use App\Observers\RefObserver;
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
        Convertation::observe(ConvertationObserver::class);
        Article::observe(ArticleObserver::class);
        Server::observe(ServerObserver::class);
        Order::observe(OrderObserver::class);
        Nft::observe(NftObserver::class);
        Coin::observe(CoinObserver::class);
        ConfigurationGroup::observe(ConfigurationObserver::class);
        ConfigurationField::observe(ConfigurationObserver::class);
        ConfigurationOption::observe(ConfigurationObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
