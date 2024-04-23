<?php

namespace App\Filament\Manager\Resources;

use App\Filament\Actions\SetOperatorBulkGroupAction;
use App\Filament\Actions\UserArchiveAction;
use App\Filament\Actions\UserArchiveBulkAction;
use App\Filament\Manager\Resources\CallResource\Pages;
use App\Models\User;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CallResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Новые пользователи';

    protected static ?string $label = 'Новые пользователи';
    protected static ?string $pluralLabel = 'Новые пользователи';

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
                UserArchiveAction::make(),
            ])
            ->bulkActions([
                UserArchiveBulkAction::make(),
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
            ->notCall();
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()
            ::notAdmin()
            ->notOperator()
            ->notManager()
            ->where('manager_id', auth()->id())
            ->notCall()
            ->count();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCalls::route('/'),
        ];
    }
}
