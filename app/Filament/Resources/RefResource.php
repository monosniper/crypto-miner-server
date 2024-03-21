<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RefResource\Pages;
use App\Filament\Resources\RefResource\RelationManagers;
use App\Models\Ref;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RefResource extends Resource
{
    protected static ?string $model = Ref::class;

    protected static ?string $navigationIcon = 'heroicon-s-link';

    protected static ?string $navigationLabel = 'Реф. система';

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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Пользователь')
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->label('Код')
                    ->copyable()
                    ->copyableState(fn (string $state): string => "https://hogyx.io/?ref_code={$state}")
                    ->searchable(),
                Tables\Columns\TextColumn::make('users_count')
                    ->label('Кол-во рег-ий')
                    ->sortable()
                    ->counts('users'),
                Tables\Columns\TextColumn::make('donates_total')
                    ->label('Сумма пополнений')
                    ->sortable()
                    ->state(fn (Ref $ref) => $ref->totalDonates())
                    ->money(),
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
            'index' => Pages\ListRefs::route('/'),
            'create' => Pages\CreateRef::route('/create'),
            'edit' => Pages\EditRef::route('/{record}/edit'),
        ];
    }
}
