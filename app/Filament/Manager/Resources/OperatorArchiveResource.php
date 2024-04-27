<?php

namespace App\Filament\Manager\Resources;

use App\Filament\Actions\ArchiveAction;
use App\Filament\Actions\ArchiveBulkAction;
use App\Filament\Actions\OperatorUnarchiveAction;
use App\Filament\Actions\OperatorUnarchiveBulkAction;
use App\Filament\Manager\Resources\OperatorArchiveResource\Pages;
use App\Models\Call;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OperatorArchiveResource extends Resource
{
    protected static ?string $model = Call::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Архив операторов';
    protected static ?string $pluralLabel = 'Архив операторов';
    protected static ?string $navigationLabel = 'Операторов';

    protected static ?string $navigationGroup = 'Архив';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll()
            ->defaultPaginationPageOption(50)
            ->columns([
                TextColumn::make('user')
                    ->label('Пользователь')
                    ->icon(fn (Call $call): string => $call->user->country_code ? 'icon-' . mb_strtolower($call->user->country_code) : '')
                    ->state(fn (Call $call) => $call->user->full_name)
                    ->searchable(),
                TextColumn::make('operator')
                    ->label('Оператор')
                    ->state(fn (Call $record) => $record->operator->full_name)
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                (new ArchiveAction(isOperator: true))(),
            ])
            ->bulkActions([
                (new ArchiveAction(isOperator: true, isBulk: true))(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('user', fn(Builder $query) => $query->where('manager_id', auth()->id()))
            ->operatorArchive();
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()
            ::whereHas('user', fn(Builder $query) => $query->where('manager_id', auth()->id()))
            ->operatorArchive()
            ->count();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOperatorArchives::route('/'),
        ];
    }
}
