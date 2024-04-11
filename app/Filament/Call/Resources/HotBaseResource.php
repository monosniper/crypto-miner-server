<?php

namespace App\Filament\Call\Resources;

use App\Filament\Call\Resources\HotBaseResource\Pages;
use App\Filament\Call\Resources\HotBaseResource\RelationManagers;
use App\Models\HotBase;
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

class HotBaseResource extends Resource
{
    protected static ?string $model = OperatorReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-fire';

    protected static ?string $navigationLabel = 'Горячая база';

    protected static ?string $navigationGroup = 'Колл-центр';

    protected static ?string $label = 'Номера';
    protected static ?string $pluralLabel = 'Номера';

    public static function table(Table $table): Table
    {
        return $table
            ->poll()
            ->defaultPaginationPageOption(50)
            ->modifyQueryUsing(fn (Builder $query) => $query
                ->hot()
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
                    ->limit(30)
                    ->html()
                    ->searchable(),
                TextInputColumn::make('amount')
                    ->label('Сумма донатов')
                    ->type('number')
                    ->sortable(),
                SelectColumn::make('status')
                    ->label('Статус')
                    ->width(150)
                    ->options([
                        OperatorReport::STATUS_NOT_CALLED => __("operators.statuses.".OperatorReport::STATUS_NOT_CALLED),
                        OperatorReport::STATUS_CALLED => __("operators.statuses.".OperatorReport::STATUS_CALLED),
                        OperatorReport::STATUS_NOT_ACCEPTED => __("operators.statuses.".OperatorReport::STATUS_NOT_ACCEPTED),
                    ]),
                Tables\Columns\TextColumn::make('user.created_at')
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
//                SelectFilter::make('user')
//                    ->label('Страна')
//                    ->options(User::distinct()->whereNotNull('country_code')->pluck('country_code')->toArray())
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
        return static::getModel()::hot()->count();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHotBases::route('/'),
        ];
    }
}
