<?php

namespace App\Filament\Manager\Resources;

use App\Enums\ReportStatus;
use App\Filament\Actions\ArchiveAction;
use App\Filament\Actions\SetOperatorBulkGroupAction;
use App\Filament\Manager\Resources\CallResource\Pages;
use App\Models\User;
use App\Queries\UserReportsQuery;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class CallResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Новые';

    protected static ?string $label = 'Новые пользователи';
    protected static ?string $pluralLabel = 'Новые пользователи';

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
            ->notStaff()
            ->where('manager_id', auth()->id())
            ->whereNotIn('id', (new UserReportsQuery())())
            ->notCall();
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getEloquentQuery()->count();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCalls::route('/'),
        ];
    }
}
