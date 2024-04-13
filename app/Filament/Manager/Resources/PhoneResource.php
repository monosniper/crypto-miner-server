<?php

namespace App\Filament\Manager\Resources;

use App\Filament\Manager\Resources\PhoneResource\Pages;
use App\Models\OperatorReport;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class PhoneResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Номера';

    protected static ?string $label = 'Номера';
    protected static ?string $pluralLabel = 'Номера';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll()
            ->defaultPaginationPageOption(50)
            ->columns([
                TextColumn::make('report.user')
                    ->label('Номер')
//                    ->icon(fn (User $record): string => $record->country_code ? 'icon-' . mb_strtolower($record->country_code) : '')
                    ->formatStateUsing(fn (User $state): View => view(
                        'filament.columns.tel',
                        ['state' => $state],
                    ))
                    ->searchable(),
                Tables\Columns\TextColumn::make('report.operator')
                    ->label('Оператор')
                    ->formatStateUsing(fn (User $state) => $state->first_name . ' ' . $state->last_name)
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // TODO: to archive
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([BulkAction::make('to_archive')
                    ->label("В архив")
                    ->action(function (Collection $records) {
                        foreach ($records as $record) {
                            $record->report()->create([
                                'isArchive' => true
                            ]);
                        }
                    }),
                    ...array_map(function ($operator) {
                        return BulkAction::make('set_operator_'.$operator['id'])
                            ->label("Назначить " . ($operator['first_name'] ? ($operator['first_name'] . ' ' . $operator['last_name']) : $operator['name']))
                            ->requiresConfirmation()
                            ->action(function (Collection $records) use($operator) {
                                foreach ($records as $record) {
                                    $record->report()->create([
                                        'operator_id' => $operator['id']
                                    ]);
                                }
                            });
                }, User::operators()->get()->toArray())]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->notArchive()->with('report.operator', 'report.user');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::notArchive()->count();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPhones::route('/'),
        ];
    }
}
