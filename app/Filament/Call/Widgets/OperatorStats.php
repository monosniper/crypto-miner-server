<?php

namespace App\Filament\Call\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Number;

class OperatorStats extends BaseWidget
{
    private User $user;
    private HasMany $calls;
    private HasMany $reports;
    private HasMany $successCalls;
    private HasMany $notSuccessCalls;

    public function __construct()
    {
        $this->user = auth()->user();
        $this->calls = $this->user->calls()->called();
        $this->reports = $this->user->myReports();
        $this->successCalls = $this->calls->success();
        $this->notSuccessCalls = $this->calls->notSuccess();
    }

    public function getDonatesSum($month = false): int
    {
        $result = $this->calls->notSuccess();

        if($month) {
            $result->forMonth();
        }

        return '$'.Number::format($result, 2);
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Кол-во звонков', $this->calls->count())
                ->description('За все время'),
            Stat::make('Кол-во звонков', $this->calls->forMonth()->count())
                ->description('За месяц'),
            Stat::make('Отправлено отчетов', $this->reports->count())
                ->description('За все время'),
            Stat::make('Отправлено отчетов', $this->reports->forMonth()->count())
                ->description('За месяц'),

            Stat::make('Успешные звонки', $this->successCalls->count())
                ->description('За все время'),
            Stat::make('Успешные звонки', $this->successCalls->forMonth()->count())
                ->description('За месяц'),
            Stat::make('Недачные звонки', $this->notSuccessCalls->count())
                ->description('За все время'),
            Stat::make('Недачные звонки', $this->notSuccessCalls->forMonth()->count())
                ->description('За месяц'),

//            Stat::make('Сумма донатов', $this->getDonatesSum())
//                ->description('За все время'),
//            Stat::make('Сумма донатов', $this->getDonatesSum(month: true))
//                ->description('За месяц'),
//            Stat::make('Сумма донатов напрямую', '$'.Number::format(100, 2))
//                ->description('За все время'),
//            Stat::make('Сумма донатов напрямую', $this->getCallsCount(month: true))
//                ->description('За месяц'),
        ];
    }

    protected function getColumns(): int
    {
        return 4;
    }
}
