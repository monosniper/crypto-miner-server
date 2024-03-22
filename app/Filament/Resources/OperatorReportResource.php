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


    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([])
            ->columns([
                Tables\Columns\TextColumn::make('operator.name')
                    ->label('Оператор')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Пользователь')
                    ->searchable(),
                Tables\Columns\TextColumn::make('comment')
                    ->label('Комментарий')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Сумма донатов')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        OperatorReport::STATUS_CALLED => 'success',
                        OperatorReport::STATUS_NOT_CALLED => 'danger',
                        OperatorReport::STATUS_NOT_ACCEPTED => 'gray',
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
                    ])
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
