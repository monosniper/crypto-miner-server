<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PossibilityResource\Pages;
use App\Filament\Resources\PossibilityResource\RelationManagers;
use App\Models\Possibility;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PossibilityResource extends Resource
{
    protected static ?string $model = Possibility::class;

    protected static ?string $navigationIcon = 'heroicon-s-star';

    protected static ?string $navigationLabel = 'Серверные возможности';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Название')
                    ->required()
                    ->maxLength(191),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Название')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
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
            'index' => Pages\ListPossibilities::route('/'),
            'create' => Pages\CreatePossibility::route('/create'),
            'edit' => Pages\EditPossibility::route('/{record}/edit'),
        ];
    }
}
