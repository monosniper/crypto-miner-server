<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OperatorReportResource\Pages;
use App\Filament\Resources\OperatorReportResource\RelationManagers;
use App\Models\OperatorReport;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OperatorReportResource extends Resource
{
    protected static ?string $model = OperatorReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

    protected static ?string $navigationLabel = 'Отчетность';

    protected static ?string $navigationGroup = 'Колл-центр';

    protected static ?string $label = 'Отчетность';
    protected static ?string $pluralLabel = 'Отчетность';

    public static function table(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(50)
            ->columns([
                TextColumn::make('operator')
                    ->label('Оператор')
                    ->formatStateUsing(function (string $state): string {
                        $record = json_decode($state);
                        return $record->first_name . ' ' . $record->last_name;
                    })
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Пользователь')
                    ->searchable(),
                TextColumn::make('comment')
                    ->label('Комментарий')
                    ->searchable(),
                TextColumn::make('amount')
                    ->label('Сумма донатов')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        OperatorReport::STATUS_CALLED => 'success',
                        OperatorReport::STATUS_NOT_CALLED => 'gray',
                        OperatorReport::STATUS_NOT_ACCEPTED => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => __("operators.statuses.{$state}")),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Статус')
                    ->options([
                        OperatorReport::STATUS_CALLED => __("operators.statuses.".OperatorReport::STATUS_CALLED),
                        OperatorReport::STATUS_NOT_CALLED => __("operators.statuses.".OperatorReport::STATUS_NOT_CALLED),
                        OperatorReport::STATUS_NOT_ACCEPTED => __("operators.statuses.".OperatorReport::STATUS_NOT_ACCEPTED),
                    ]),
                SelectFilter::make('operator')
                    ->label('Оператор')
                    ->relationship('operator', 'name', function (Builder $query) {
                        return $query->operators()->selectRaw("id, concat(`first_name`, ' ', `last_name`) as name");
                    })
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOperatorReports::route('/'),
        ];
    }
}
