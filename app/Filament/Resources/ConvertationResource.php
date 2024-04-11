<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConvertationResource\Pages;
use App\Filament\Resources\ConvertationResource\RelationManagers;
use App\Models\Convertation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ConvertationResource extends Resource
{
    protected static ?string $model = Convertation::class;

    protected static ?string $navigationIcon = 'heroicon-s-scale';

    protected static ?string $navigationLabel = 'Конвертации';

    protected static ?string $navigationGroup = 'Статистика';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Пользователь')
                    ->relationship(name: 'user', titleAttribute: 'name')
                    ->searchable(['name'])
                    ->required(),
                Forms\Components\Select::make('from_id')
                    ->label('Монета 1')
                    ->relationship(name: 'from', titleAttribute: 'name')
                    ->required(),
                Forms\Components\Select::make('to_id')
                    ->label('Монета 2')
                    ->relationship(name: 'to', titleAttribute: 'name')
                    ->required(),
                Forms\Components\TextInput::make('amount_from')
                    ->label('Кол-во')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Пользователь')
                    ->searchable(),
                Tables\Columns\TextColumn::make('from.name')
                    ->label('Монета 1')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('to.name')
                    ->label('Монета 2')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount_from')
                    ->label('Кол-во 1')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount_to')
                    ->label('Кол-во 2')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Посл. обновление')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([

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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['from', 'to']);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListConvertations::route('/'),
            'create' => Pages\CreateConvertation::route('/create'),
            'edit' => Pages\EditConvertation::route('/{record}/edit'),
        ];
    }
}
