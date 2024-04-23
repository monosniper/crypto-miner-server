<?php

namespace App\Filament\Manager\Resources\ReportResource\Pages;

use App\Enums\CallStatus;
use App\Enums\ReportStatus;
use App\Filament\Actions\AcceptReportAction;
use App\Filament\Actions\RejectReportAction;
use App\Filament\Manager\Resources\ReportResource;
use App\Models\Call;
use App\Models\Report;
use App\Models\User;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\View\View;

class ViewReport extends ViewRecord
{
    protected static string $resource = ReportResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
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
                        TextEntry::make('amount')
                            ->label('Сумма донатов')
                            ->money(),
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
            ]);
    }

    protected function getHeaderActions(): array
    {
        return $this->getRecord()->status === ReportStatus::SENT ? [
            AcceptReportAction::make()->requiresConfirmation(),
            RejectReportAction::make()->requiresConfirmation(),
        ] : [];
    }
}
