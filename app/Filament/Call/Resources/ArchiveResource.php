<?php

namespace App\Filament\Call\Resources;

use App\Filament\Actions\ArchiveAction;
use App\Filament\Call\Resources\ArchiveResource\Pages;
use App\Filament\Rows\CallRow;
use App\Models\Call;
use App\Models\OperatorReport;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ArchiveResource extends Resource
{
    protected static ?string $model = Call::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $navigationLabel = 'Архив';

    protected static ?string $label = 'Архив';
    protected static ?string $pluralLabel = 'Архив';

    public static function table(Table $table): Table
    {
        return $table
            ->poll()
            ->defaultPaginationPageOption(50)
            ->columns(CallRow::make())
            ->filters([
//                SelectFilter::make('status')
//                    ->label('Статус')
//                    ->options([
//                        OperatorReport::STATUS_CALLED => __("operators.statuses.".OperatorReport::STATUS_CALLED),
//                        OperatorReport::STATUS_NOT_CALLED => __("operators.statuses.".OperatorReport::STATUS_NOT_CALLED),
//                        OperatorReport::STATUS_NOT_ACCEPTED => __("operators.statuses.".OperatorReport::STATUS_NOT_ACCEPTED),
//                    ]),
            ])
            ->actions([
                (new ArchiveAction(
                    false,
                    isOperator: true
                ))()
            ])
            ->bulkActions([
                (new ArchiveAction(
                    false,
                    isOperator: true,
                    isBulk: true,
                ))(),
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->operatorArchive()
            ->where('operator_id', auth()->id());
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()
            ::operatorArchive()
            ->where('operator_id', auth()->id())
            ->count();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArchives::route('/'),
        ];
    }
}
