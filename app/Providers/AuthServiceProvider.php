<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        FilamentAsset::register([
            Css::make('../libs/jquery-jvectormap-2.0.5', public_path('css/libs/jquery-jvectormap-2.0.5.css')),
            Css::make('../libs/world', public_path('css/libs/world.css')),
            Js::make('jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js'),
            Js::make('../libs/jquery.jvectormap.min', public_path('js/libs/jquery.jvectormap.min.js')),
            Js::make('../libs/jquery-jvectormap-world-mill', public_path('js/libs/jquery-jvectormap-world-mill.js')),
            Js::make('../libs/world', public_path('js/libs/world.js')),
        ]);
    }
}
