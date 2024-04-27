<?php

namespace App\Filament\Rows;

use App\Enums\CallStatus;
use App\Enums\ReportStatus;
use App\Models\Call;
use App\Models\Report;
use App\Models\User;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Number;
use Illuminate\View\View;

class ReportRaw
{
    static public function make(): array
    {
        return [
            Grid::make(4)
                ->schema([
                    TextEntry::make('operator')
                        ->label('Оператор')
                        ->state(fn (Report $record) => $record->operator->full_name),
                    TextEntry::make('status_string')
                        ->label('Статус')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            ReportStatus::SENT->value => 'gray',
                            ReportStatus::ACCEPTED->value => 'success',
                            ReportStatus::REJECTED->value => 'danger',
                        })
                        ->formatStateUsing(fn (string $state): string => __("report.statuses.{$state}")),
                    TextEntry::make('base')
                        ->label('База')
                        ->badge()
                        ->limitList(1)
                        ->color('primary')
                        ->state(function (Report $record): string {
                            $type = $record->calls->first()->isHot ? 'hot' : 'cold';

                            return __("report.base.{$type}");
                        }),
                    TextEntry::make('created_at')
                        ->label('Дата создания')
                        ->dateTime(),
                ]),
            RepeatableEntry::make('calls')
                ->label('Звонки')
                ->schema([
                    TextEntry::make('user')
                        ->label('Номер')
                        ->icon(fn (Call $record): string => $record->user->country_code ? 'icon-' . mb_strtolower($record->user->country_code) : '')
                        ->formatStateUsing(fn (User $state): View => view(
                            'filament.columns.tel',
                            ['state' => $state],
                        )),
                    TextEntry::make('orders_sum_amount')
                        ->label('Сумма донатов')
                        ->state(fn (Call $record) =>
                            '$' . Number::format(
                                $record->user()->withSum(
                                    ['orders' => fn (Builder $query) => $query->completed()], 'amount'
                                )->first()->orders_sum_amount,
                                precision: 2
                            ) . ' ($' . Number::format($record->amount, precision: 2) . ')'
                        ),
                    TextEntry::make('status_string')
                        ->label('Статус')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            CallStatus::NOT_CALLED->value => 'danger',
                            CallStatus::NOT_ACCEPTED->value => 'gray',
                            CallStatus::CALLED->value => 'success',
                        })
                        ->formatStateUsing(fn (string $state): string => __("call.statuses.{$state}")),
                    TextEntry::make('comment')
                        ->label('Комментарий')
                        ->html()
                        ->columnSpan(3),
                ])
                ->grid()
                ->columns(3)
                ->columnSpan(3),
        ];
    }
}
