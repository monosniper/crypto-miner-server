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
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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
                    ->relationship(name: 'server', titleAttribute: 'title')
                    ->searchable(['title'])
                    ->required(),
//                Forms\Components\TextInput::make('name')
//                    ->label('Название')
//                    ->maxLength(191),
//                DateTimePicker::make('active_until')
//                    ->required()
//                    ->label('Активен до'),
                Select::make('status')
                    ->label('Статус')
                    ->required()
                    ->options([
                        Server::ACTIVE_STATUS => __("servers.statuses.".Server::ACTIVE_STATUS),
                        Server::WORK_STATUS => __("servers.statuses.".Server::WORK_STATUS),
                        Server::NOT_ACTIVE_STATUS => __("servers.statuses.".Server::NOT_ACTIVE_STATUS),
                        Server::RELOAD_STATUS => __("servers.statuses.".Server::RELOAD_STATUS),
                    ])
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
                    ->label('Название сервера')
                    ->searchable(),
                Tables\Columns\TextColumn::make('server.title')
                    ->label('Сервер')
                    ->searchable(),
                Tables\Columns\TextColumn::make('active_until')
                    ->label('Активен до')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        Server::ACTIVE_STATUS => 'success',
                        Server::NOT_ACTIVE_STATUS => 'danger',
                        Server::RELOAD_STATUS => 'gray',
                        Server::WORK_STATUS => 'warning',
                    })
                    ->formatStateUsing(fn (string $state): string => __("servers.statuses.{$state}"))
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
                SelectFilter::make('status')
                    ->label('Статус')
                    ->options([
                        Server::ACTIVE_STATUS => __("servers.statuses.".Server::ACTIVE_STATUS),
                        Server::WORK_STATUS => __("servers.statuses.".Server::WORK_STATUS),
                        Server::NOT_ACTIVE_STATUS => __("servers.statuses.".Server::NOT_ACTIVE_STATUS),
                        Server::RELOAD_STATUS => __("servers.statuses.".Server::RELOAD_STATUS),
                    ])
            ])
            ->actions([
                Tables\Actions\CreateAction::make()
                    ->after(function ($record, $state) {
                        $key = 'servers.'.$record->user_id;
                        Cache::forget($key);
                        Cache::remember($key, 86400, function () use($record) {
                            return $record->user->servers;
                        });
                    }),
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
            'index' => Pages\ListUserServers::route('/'),
            'create' => Pages\CreateUserServer::route('/create'),
            'edit' => Pages\EditUserServer::route('/{record}/edit'),
        ];
    }
}
