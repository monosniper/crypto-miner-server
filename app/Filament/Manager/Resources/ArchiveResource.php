<?php

namespace App\Filament\Manager\Resources;

use App\Filament\Actions\UnarchiveAction;
use App\Filament\Actions\UnarchiveBulkAction;
use App\Filament\Manager\Resources\ArchiveResource\Pages;
use App\Models\Call;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ArchiveResource extends Resource
{
    protected static ?string $model = Call::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Мой';
    protected static ?string $label = 'Мой архив';
    protected static ?string $pluralLabel = 'Мой архив';

    protected static ?string $navigationGroup = 'Архив';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(50)
            ->columns([
                TextColumn::make('user')
                    ->label('Пользователь')
                    ->icon(fn (Call $call): string => $call->user->country_code ? 'icon-' . mb_strtolower($call->user->country_code) : '')
                    ->state(fn (Call $call) => $call->user->full_name)
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                UnarchiveAction::make(),
            ])
            ->bulkActions([
                UnarchiveBulkAction::make(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('user', fn(Builder $query) => $query->where('manager_id', auth()->id()))
            ->archive();
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()
            ::archive()
            ->whereHas('user', fn(Builder $query) => $query->where('manager_id', auth()->id()))
            ->count();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArchives::route('/'),
        ];
    }
}
