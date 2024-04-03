<?php

namespace App\Filament\Call\Resources;

use App\Filament\Call\Resources\ColdBaseResource\Pages;
use App\Filament\Call\Resources\ColdBaseResource\RelationManagers;
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
    protected static ?string $model = OperatorReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-stop-circle';

    protected static ?string $navigationLabel = 'Холодная база';

    protected static ?string $navigationGroup = 'Колл-центр';

    protected static ?string $label = 'Номера';
    protected static ?string $pluralLabel = 'Номера';

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
            ->columns([
                TextColumn::make('user')
                    ->label('Номер')
                    ->icon(fn (OperatorReport $record): string => $record->user->country_code ? 'icon-' . mb_strtolower($record->user->country_code) : '')
                    ->formatStateUsing(fn (User $state): View => view(
                        'filament.columns.tel',
                        ['state' => $state],
                    ))
                    ->searchable(),
                TextColumn::make('comment')
                    ->label('Комментарий')
                    ->limit(50)
                    ->html()
                    ->searchable(),
                TextInputColumn::make('amount')
                    ->label('Сумма донатов')
                    ->type('number')
                    ->sortable(),
                SelectColumn::make('status')
                    ->label('Статус')
                    ->options([
                        OperatorReport::STATUS_NOT_CALLED => __("operators.statuses.".OperatorReport::STATUS_NOT_CALLED),
                        OperatorReport::STATUS_CALLED => __("operators.statuses.".OperatorReport::STATUS_CALLED),
                        OperatorReport::STATUS_NOT_ACCEPTED => __("operators.statuses.".OperatorReport::STATUS_NOT_ACCEPTED),
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата рег.')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Статус')
                    ->options([
                        OperatorReport::STATUS_CALLED => __("operators.statuses.".OperatorReport::STATUS_CALLED),
                        OperatorReport::STATUS_NOT_CALLED => __("operators.statuses.".OperatorReport::STATUS_NOT_CALLED),
                        OperatorReport::STATUS_NOT_ACCEPTED => __("operators.statuses.".OperatorReport::STATUS_NOT_ACCEPTED),
                    ]),
            ])
            ->actions([
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
                Tables\Actions\BulkAction::make('to_archive')
                    ->label('В архив')
                    ->action(function (Collection $records) {
                        foreach ($records as $record) {
                            $item = OperatorReport::find($record['id']);
                            $item->update([
                                'isArchive' => true
                            ]);
                        }
                    })
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::cold()->count();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListColdBases::route('/'),
        ];
    }
}
