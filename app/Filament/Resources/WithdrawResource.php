<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WithdrawResource\Pages;
use App\Filament\Resources\WithdrawResource\RelationManagers;
use App\Models\Withdraw;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WithdrawResource extends Resource
{
    protected static ?string $model = Withdraw::class;

    protected static ?string $navigationIcon = 'heroicon-s-arrow-left-on-rectangle';

    protected static ?string $navigationLabel = 'Выводы';

    protected static ?string $navigationGroup = 'Статистика';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship(name: 'user', titleAttribute: 'name')
                    ->label("Пользователь")
                    ->searchable(['name'])
                    ->required(),
                Forms\Components\TextInput::make('wallet')
                    ->label("Кошелек")
                    ->required()
                    ->maxLength(1000),
                Forms\Components\TextInput::make('amount')
                    ->label("Сумма")
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('type')
                    ->label('Тип')
                    ->default(Withdraw::TYPE_COIN)
                    ->options([
                        Withdraw::TYPE_COIN => 'Криптовалюта',
                        Withdraw::TYPE_NFT => 'НФТ',
                    ]),
                Forms\Components\Select::make('nft_id')
                    ->relationship(name: 'nft', titleAttribute: 'name')
                    ->label("НФТ")
                    ->searchable(['name'])
                    ->requiredIf('type', Withdraw::TYPE_NFT),
                Forms\Components\Select::make('status')
                    ->label('Статус')
                    ->default(Withdraw::STATUS_PENDING)
                    ->options([
                        Withdraw::STATUS_FAILED => 'Ошибка',
                        Withdraw::STATUS_PENDING => 'Ожидание',
                        Withdraw::STATUS_SUCCESS => 'Успешно',
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label("Пользователь")
                    ->searchable(),
                Tables\Columns\TextColumn::make('wallet')
                    ->label("Кошелек")
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label("Тип")
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label("Статус")
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label("Сумма")
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label("Дата создания")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label("Посл. Изменение")
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
            'index' => Pages\ListWithdraws::route('/'),
            'create' => Pages\CreateWithdraw::route('/create'),
            'edit' => Pages\EditWithdraw::route('/{record}/edit'),
        ];
    }
}
