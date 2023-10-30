<?php

namespace App\Filament\PR\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Всего приглашено', auth()->user()->team->getTotalRefsCount()),
        ];
    }
}
