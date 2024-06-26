<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-s-user-group';

    protected static ?string $navigationLabel = 'Пользователи';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Ник')
                    ->required()
                    ->maxLength(191),

                Forms\Components\TextInput::make('first_name')
                    ->label('Имя')
                    ->required()
                    ->maxLength(191),

                Forms\Components\TextInput::make('last_name')
                    ->label('Фамилия')
                    ->required()
                    ->maxLength(191),

                Forms\Components\TextInput::make('email')
                    ->label('Почта')
                    ->email()
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('phone')
                    ->required()
                    ->label('Номер'),
                Forms\Components\Toggle::make('isVerificated')
                    ->label('Верифицирован')
                    ->required(),
                Forms\Components\Toggle::make('isAdmin')
                    ->label('Админ')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Имя')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Почта')
                    ->searchable(),
                Tables\Columns\TextColumn::make('orders_sum_amount')
                    ->label('Сумма пополнений')
                    ->default(0)
                    ->money(),
                Tables\Columns\IconColumn::make('isAdmin')
                    ->label('Админ')
                    ->sortable()
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
                Filter::make('isAdmin')
                    ->label('Админ')
                    ->query(fn (Builder $query) => $query->where('isAdmin', true)),
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withSum('orders', 'amount');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
