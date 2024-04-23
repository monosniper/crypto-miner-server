<?php

namespace App\Filament\Call\Resources;

use App\Enums\CallStatus;
use App\Filament\Actions\OperatorArchiveAction;
use App\Filament\Actions\OperatorArchiveBulkAction;
use App\Filament\Actions\ReportBulkAction;
use App\Filament\Call\Resources\ColdBaseResource\Pages;
use App\Filament\Call\Resources\ColdBaseResource\RelationManagers;
use App\Filament\Rows\CallRow;
use App\Models\Call;
use App\Models\ColdBase;
use App\Models\OperatorReport;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\View\View;

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
            ->modifyQueryUsing(fn (Builder $query) => $query
                ->cold()
                ->where('operator_id', auth()->id())
            )
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
                OperatorArchiveAction::make(),
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
                OperatorArchiveBulkAction::make(),
                ReportBulkAction::make(),
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
