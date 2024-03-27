<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PhonesResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PhonesResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone';

    protected static ?string $navigationLabel = 'Номера';

    protected static ?string $navigationGroup = 'Колл-центр';

    public static function table(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(50)
            ->columns([
                Tables\Columns\TextColumn::make('phone')
                    ->label('Номер')
                    ->searchable(),
                Tables\Columns\TextColumn::make('report')
                    ->label('Оператор')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->bulkActions([
                BulkAction::make('set_operator')
                    ->label('Назначить')
                    ->action(function (Collection $records) {
                        foreach ($records as $record) {
                            $user = User::find($record['id']);
                            $user->report()->create([
                                'operator_id' => 1002,
                                'user_id' => $record['id']
                            ]);
                        }
                    })
//                ActionGroup::make([
//                    Action::make('set_operator')
//                        ->label('Назначить')
//                        ->action(function () {
//                            info("HELLO");
//                        }),
//                ])
//                ActionGroup::make(array_map(function ($operator) {
//                    return Action::make('set_operator_' . $operator['id'])
//                        ->label('Назначить ' . $operator['first_name'] . ' ' . $operator['last_name']);
////                        ->url(fn (): string => route('test', ['post' => $this->post]));
////                        ->action(fn () => info('json_encode($this)'));
//                }, User::operators()->get()->toArray()))
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPhones::route('/'),
        ];
    }
}
