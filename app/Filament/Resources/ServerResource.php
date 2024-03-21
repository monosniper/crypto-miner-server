<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServerResource\Pages;
use App\Filament\Resources\ServerResource\RelationManagers;
use App\Models\Server;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServerResource extends Resource
{
    protected static ?string $model = Server::class;

    protected static ?string $navigationIcon = 'heroicon-s-server-stack';

    protected static ?string $navigationLabel = 'Сервера';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Название')
                    ->required()
                    ->maxLength(191),
                SpatieMediaLibraryFileUpload::make('icon')
                    ->label('Иконка')
                    ->image()
                    ->imageEditor()
                    ->collection('icon')
                    ->directory('servers'),
                Forms\Components\TextInput::make('price')
                    ->label('Цена за месяц')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\TextInput::make('year_price')
                    ->label('Цена за год')
                    ->required()
                    ->numeric()
                    ->prefix('$'),

                Forms\Components\Toggle::make('nft')
                    ->label('Может фармить НФТ')
                    ->required(),
                Forms\Components\Toggle::make('isHot')
                    ->label('Рекомендовано')
                    ->required(),
                Forms\Components\Select::make('possibilities')
                    ->label('Возможности')
                    ->relationship(name: 'possibilities', titleAttribute: 'name')
                    ->multiple(),
                Forms\Components\Select::make('coins')
                    ->label('Монеты')
                    ->relationship(name: 'coins', titleAttribute: 'name')
                    ->multiple()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('icon')
                    ->label('Иконка')
                    ->collection('icon'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Название')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Цена')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('year_price')
                    ->label('Цена в год')
                    ->money()
                    ->sortable(),
                Tables\Columns\IconColumn::make('nft')
                    ->label('НФТ')
                    ->boolean(),
                Tables\Columns\IconColumn::make('isHot')
                    ->label('Рекомендовано')
                    ->boolean(),
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListServers::route('/'),
            'create' => Pages\CreateServer::route('/create'),
            'edit' => Pages\EditServer::route('/{record}/edit'),
        ];
    }
}
