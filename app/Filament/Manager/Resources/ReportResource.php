<?php

namespace App\Filament\Manager\Resources;

use App\Enums\ReportStatus;
use App\Filament\Manager\Resources\ReportResource\Pages;
use App\Models\Report;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Отчеты';
    protected static ?string $pluralLabel = 'Отчеты';
    protected static ?string $navigationLabel = 'Отчеты';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('operator')
                    ->label('Оператор')
                    ->state(fn (Report $record) => $record->operator->full_name)
                    ->searchable(),
                TextColumn::make('calls_count')
                    ->label('Кол-во номеров')
                    ->counts('calls')
                    ->sortable(),
                TextColumn::make('status_string')
                    ->label('Статус')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        ReportStatus::SENT->value => 'gray',
                        ReportStatus::ACCEPTED->value => 'success',
                        ReportStatus::REJECTED->value => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => __("report.statuses.{$state}")),
                TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([

            ])
            ->bulkActions([

            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('calls.user', fn(Builder $query) => $query->where('manager_id', auth()->id()));
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()
            ::whereHas('calls.user', fn(Builder $query) => $query->where('manager_id', auth()->id()))
            ->count();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReports::route('/'),
            'view' => Pages\ViewReport::route('/{record}'),
        ];
    }
}
