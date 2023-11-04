<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserServerResource\Pages;
use App\Filament\Resources\UserServerResource\RelationManagers;
use App\Models\Server;
use App\Models\UserServer;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserServerResource extends Resource
{
    protected static ?string $model = UserServer::class;

    protected static ?string $navigationIcon = 'heroicon-o-server-stack';

    protected static ?string $navigationLabel = 'Сервера пользователей';

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
                Forms\Components\Select::make('server_id')
                    ->label('Сервер')
                    ->relationship(name: 'user', titleAttribute: 'title')
                    ->searchable(['title'])
                    ->required(),
                DateTimePicker::make('work_started_at')
                    ->label('Время начала работы'),
                DateTimePicker::make('active_until')
                    ->label('Активен до'),
                Select::make('status')
                    ->label('Статус')
                    ->options(Server::STATUSES)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Пользователь')
                    ->searchable(),
                Tables\Columns\TextColumn::make('server.title')
                    ->label('Сервер')
                    ->searchable(),
                Tables\Columns\TextColumn::make('work_started_at')
                    ->label('Время начала работы')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('active_until')
                    ->label('Активен до')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Статус')
                    ->searchable(),
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
            'index' => Pages\ListUserServers::route('/'),
            'create' => Pages\CreateUserServer::route('/create'),
            'edit' => Pages\EditUserServer::route('/{record}/edit'),
        ];
    }
}
