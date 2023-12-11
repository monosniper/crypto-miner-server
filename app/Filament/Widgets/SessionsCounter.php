<?php

namespace App\Filament\Widgets;

use App\Models\Session;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SessionsCounter extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Запущено сессий', Session::count()),
        ];
    }
}
