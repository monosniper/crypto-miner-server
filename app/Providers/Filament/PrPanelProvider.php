<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class PrPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
//            ->spa()
            ->id('pr')
            ->domain(env('PANEL_PR_DOMAIN'))
//            ->path(env('PANEL_PR_PATH', ''))
            ->login()
            ->passwordReset()
//            ->authPasswordBroker('teams')
            ->brandName('Hogyx PR Panel')
//            ->brandLogo(asset('images/logo.svg'))
            ->favicon(asset('images/logo.svg'))

            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/PR/Resources'), for: 'App\\Filament\\PR\\Resources')
            ->discoverPages(in: app_path('Filament/PR/Pages'), for: 'App\\Filament\\PR\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/PR/Widgets'), for: 'App\\Filament\\PR\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
//            ->authGuard('team')
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
