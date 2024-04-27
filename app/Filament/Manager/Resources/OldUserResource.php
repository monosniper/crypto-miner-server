<?php

namespace App\Filament\Manager\Resources;

use App\Filament\Actions\ArchiveAction;
use App\Filament\Actions\SetOperatorBulkGroupAction;
use App\Filament\Manager\Resources\OldUserResource\Pages;
use App\Models\User;
use App\Queries\UserReportsQuery;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OldUserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Старые';

    protected static ?string $label = 'Старые пользователи';
    protected static ?string $pluralLabel = 'Старые пользователи';

    protected static ?string $navigationGroup = 'Пользователи';

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
                TextColumn::make('first_name')
                    ->label('Пользователь')
                    ->icon(fn (User $record): string => $record->country_code ? 'icon-' . mb_strtolower($record->country_code) : '')
                    ->state(fn (User $user) => $user->full_name)
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                (new ArchiveAction(isCall: false))()
            ])
            ->bulkActions([
                (new ArchiveAction(
                    false,
                    isCall: false,
                    isBulk: true
                ))(),
                SetOperatorBulkGroupAction::make(
                    isCall: false
                )->label('Назначить оператора'),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->notAdmin()
            ->notOperator()
            ->notManager()
            ->where('manager_id', auth()->id())
            ->notCall()
            ->whereIn('id', (new UserReportsQuery())());
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getEloquentQuery()->count();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOldUsers::route('/'),
        ];
    }
}
