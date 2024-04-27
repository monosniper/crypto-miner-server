<?php

namespace App\Filament\Call\Resources;

use App\Filament\Actions\ArchiveAction;
use App\Filament\Actions\OperatorArchiveAction;
use App\Filament\Actions\OperatorArchiveBulkAction;
use App\Filament\Actions\ReportBulkAction;
use App\Filament\Call\Resources\HotBaseResource\Pages;
use App\Filament\Rows\CallRow;
use App\Models\Call;
use Filament\Forms\Components\RichEditor;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class HotBaseResource extends Resource
{
    protected static ?string $model = Call::class;

    protected static ?string $navigationIcon = 'heroicon-o-fire';

    protected static ?string $navigationLabel = 'Горячая';

    protected static ?string $label = 'Горячая база';
    protected static ?string $pluralLabel = 'Горячая база';

    protected static ?string $navigationGroup = 'База';

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
//                SelectFilter::make('user')
//                    ->label('Страна')
//                    ->options(User::distinct()->whereNotNull('country_code')->pluck('country_code')->toArray())
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
            ->hot()
            ->whereDoesntHave('reports')
            ->where('operator_id', auth()->id());
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()
            ::notAnyArchive()
            ->hot()
            ->whereDoesntHave('reports')
            ->where('operator_id', auth()->id())
            ->count();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHotBases::route('/'),
        ];
    }
}
