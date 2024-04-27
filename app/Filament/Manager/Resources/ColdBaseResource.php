<?php

namespace App\Filament\Manager\Resources;

use App\Enums\ReportStatus;
use App\Filament\Actions\ArchiveAction;
use App\Filament\Actions\SetOperatorBulkGroupAction;
use App\Filament\Manager\Resources\ColdBaseResource\Pages;
use App\Models\Call;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ColdBaseResource extends Resource
{
    protected static ?string $model = Call::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Холодная';

    protected static ?string $label = 'Холодная база';
    protected static ?string $pluralLabel = 'Холодная база';

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
                SetOperatorBulkGroupAction::make(false)
                    ->label('Переназначить оператора'),
                SetOperatorBulkGroupAction::make()
                    ->label('В горячую базу'),
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
            ->whereDoesntHave(
                'reports',
                fn (Builder $query) => $query->whereNot('status', ReportStatus::ACCEPTED)
            )
            ->whereHas('user', fn(Builder $query) => $query->where('manager_id', auth()->id()))
            ->cold();
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()
            ::notAnyArchive()
            ->whereDoesntHave(
                'reports',
                fn (Builder $query) => $query->whereNot('status', ReportStatus::ACCEPTED)
            )
            ->whereHas('user', fn(Builder $query) => $query->where('manager_id', auth()->id()))
            ->cold()
            ->count();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListColdBases::route('/'),
        ];
    }
}
