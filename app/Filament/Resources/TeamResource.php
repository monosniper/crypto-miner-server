<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeamResource\Pages;
use App\Filament\Resources\TeamResource\RelationManagers;
use App\Models\Team;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeamResource extends Resource
{
    protected static ?string $model = Team::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Пиар команды';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Пользователь')
                    ->relationship(name: 'user', titleAttribute: 'name')
                    ->searchable(['name'])
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label("Название")
                    ->required()
                    ->maxLength(191),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Пользователь')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label("Название")
                    ->searchable(),
                Tables\Columns\TextColumn::make('refs_count')
                    ->label("Кол-во приглашенных")
                    ->sortable()
                    ->state(fn (Team $team) => $team->getTotalRefsCount()),
                Tables\Columns\TextColumn::make('donates_total')
                    ->label("Сумма пополнений")
                    ->money()
                    ->state(fn (Team $team) => $team->totalDonates())
                    ->sortable(),
                Tables\Columns\TextColumn::make('members_count')
                    ->label("Кол-во участников")
                    ->sortable()
                    ->counts('members'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label("Дата создания")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->defaultSort('created_at', 'desc')
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListTeams::route('/'),
            'create' => Pages\CreateTeam::route('/create'),
            'edit' => Pages\EditTeam::route('/{record}/edit'),
        ];
    }
}
