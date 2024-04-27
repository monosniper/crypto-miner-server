<?php

namespace App\Filament\Call\Resources;

use App\Filament\Actions\ArchiveAction;
use App\Filament\Actions\ReportBulkAction;
use App\Filament\Call\Resources\ColdBaseResource\Pages;
use App\Filament\Rows\CallRow;
use App\Models\Call;
use Filament\Forms\Components\RichEditor;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ColdBaseResource extends Resource
{
    protected static ?string $model = Call::class;

    protected static ?string $navigationIcon = 'heroicon-o-stop-circle';

    protected static ?string $navigationLabel = 'Холодная';

    protected static ?string $label = 'Холодная база';
    protected static ?string $pluralLabel = 'Холодная база';

    protected static ?string $navigationGroup = 'База';

    protected static ?int $navigationSort = 2;

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
                (new ArchiveAction(isOperator: true))(),
                Tables\Actions\EditAction::make('comment')
                    ->label('Комментарий')
                    ->form([
                        RichEditor::make('comment')
                            ->label('Текст')
                            ->disableToolbarButtons([
                                'codeBlock',
                                'attachFiles',
                            ])
                    ])
            ])
            ->bulkActions([
                (new ArchiveAction(
                    isOperator: true,
                    isBulk: true
                ))(),
                (new ReportBulkAction())(),
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
            ->cold()
            ->whereDoesntHave('reports')
            ->where('operator_id', auth()->id());
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()
            ::notAnyArchive()
            ->cold()
            ->whereDoesntHave('reports')
            ->count();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListColdBases::route('/'),
        ];
    }
}
