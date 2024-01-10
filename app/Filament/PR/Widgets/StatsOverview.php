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
            Stat::make('Общая сумма пополнений', auth()->user()->team->totalDonates() . "$"),
            Stat::make('Прибыль', auth()->user()->team->getIncome() . "$")
                ->description("Текущий процент - ".setting('pr_percent')."%"),
        ];
    }
}
