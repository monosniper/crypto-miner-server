<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserNftResource\Pages;
use App\Filament\Resources\UserNftResource\RelationManagers;
use App\Models\UserNft;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserNftResource extends Resource
{
    protected static ?string $model = UserNft::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'NFT пользователей';

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
                Forms\Components\Select::make('nft_id')
                    ->label('NFT')
                    ->relationship(name: 'nft', titleAttribute: 'name')
                    ->searchable(['name'])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Пользователь')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nft.name')
                    ->label('NFT')
                    ->searchable(),
                SpatieMediaLibraryImageColumn::make('nft.image')
                    ->label(''),
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
            'index' => Pages\ListUserNfts::route('/'),
            'create' => Pages\CreateUserNft::route('/create'),
            'edit' => Pages\EditUserNft::route('/{record}/edit'),
        ];
    }
}
