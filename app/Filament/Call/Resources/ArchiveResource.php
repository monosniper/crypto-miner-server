<?php

namespace App\Filament\Call\Resources;

use App\Filament\Call\Resources\ArchiveResource\Pages;
use App\Filament\Call\Resources\ArchiveResource\RelationManagers;
use App\Models\Archive;
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

class ArchiveResource extends Resource
{
    protected static ?string $model = OperatorReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $navigationLabel = 'Архив';

    protected static ?string $label = 'Номера';
    protected static ?string $pluralLabel = 'Номера';

    public static function table(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(50)
            ->modifyQueryUsing(fn (Builder $query) => $query
                ->archive()
                ->where('operator_id', auth()->id())
            )
            ->columns([
                TextColumn::make('user')
                    ->label('Номер')
                    ->icon(fn (OperatorReport $record): string => $record->user->country_code ? 'icon-' . $record->user->country_code : '')
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
                TextColumn::make('amount')
                    ->label('Сумма донатов')
                    ->money()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        OperatorReport::STATUS_NOT_CALLED => 'gray',
                        OperatorReport::STATUS_CALLED => 'success',
                        OperatorReport::STATUS_NOT_ACCEPTED => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => __("operators.statuses.{$state}")),
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
            ->actions([])
            ->bulkActions([
                Tables\Actions\BulkAction::make('from_archive')
                    ->label('Вытащить из архива')
                    ->action(function (Collection $records) {
                        foreach ($records as $record) {
                            $item = OperatorReport::find($record['id']);
                            $item->update([
                                'isArchive' => false
                            ]);
                        }
                    })
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArchives::route('/'),
        ];
    }
}
