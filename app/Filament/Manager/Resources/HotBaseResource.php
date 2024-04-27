<?php

namespace App\Filament\Manager\Resources;

use App\Filament\Actions\ArchiveAction;
use App\Filament\Actions\ArchiveBulkAction;
use App\Filament\Actions\SetOperatorBulkGroupAction;
use App\Filament\Manager\Resources\HotBaseResource\Pages;
use App\Models\Call;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class HotBaseResource extends Resource
{
    protected static ?string $model = Call::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Горячая';

    protected static ?string $label = 'Горячая база';
    protected static ?string $pluralLabel = 'Горячая база';

    protected static ?string $navigationGroup = 'База';

    public static function table(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(50)
            ->columns([
                TextColumn::make('user')
                    ->label('Пользователь')
                    ->icon(fn (Call $record): string => $record->user->country_code ? 'icon-' . mb_strtolower($record->user->country_code) : '')
                    ->state(fn (Call $record) => $record->user->full_name)
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
                (new ArchiveAction())()
            ])
            ->bulkActions([
                (new ArchiveAction(isBulk: true))(),
                SetOperatorBulkGroupAction::make()
                    ->label('Переназначить оператора'),
                SetOperatorBulkGroupAction::make(false)
                    ->label('В холодную базу'),
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->notAnyArchive()
            ->whereDoesntHave('reports')
            ->whereHas('user', fn(Builder $query) => $query->where('manager_id', auth()->id()))
            ->hot();
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()
            ::notAnyArchive()
            ->whereDoesntHave('reports')
            ->whereHas('user', fn(Builder $query) => $query->where('manager_id', auth()->id()))
            ->hot()
            ->count();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHotBases::route('/'),
        ];
    }
}
