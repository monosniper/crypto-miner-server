<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\OperatorReport;
use App\Models\Order;
use App\Models\Server;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'Счета';

    protected static ?string $navigationGroup = 'Статистика';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Пользователь')
                    ->searchable(),
                TextColumn::make('type')
                    ->label('Тип')
                    ->formatStateUsing(fn (string $state): string => __("orders.types.{$state}")),
                TextColumn::make('purchase_type')
                    ->label('Тип покупки')
                    ->formatStateUsing(fn (string $state): string => __("orders.purchase_types.{$state}")),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Сумма')
                    ->numeric()
                    ->money()
                    ->sortable(),
                TextColumn::make('method')
                    ->label('Способ оплаты')
                    ->formatStateUsing(fn (string $state): string => __("orders.methods.{$state}")),
                TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        Order::COMPLETED => 'success',
                        Order::PENDING => 'gray',
                        Order::FAILED => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => __("orders.statuses.{$state}")),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Тип')
                    ->options([
                        Order::DONATE => __("orders.types." . Order::DONATE),
                        Order::PURCHASE => __("orders.types." . Order::PURCHASE),
                    ]),
                SelectFilter::make('purchase_type')
                    ->label('Тип покупки')
                    ->options([
                        Order::SERVER => __("orders.purchase_types." . Order::SERVER),
                        Order::BALANCE => __("orders.purchase_types." . Order::BALANCE),
                    ]),
                SelectFilter::make('status')
                    ->label('Статус')
                    ->options([
                        Order::COMPLETED => __("orders.statuses." . Order::COMPLETED),
                        Order::PENDING => __("orders.statuses." . Order::PENDING),
                        Order::FAILED => __("orders.statuses." . Order::FAILED),
                    ])
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
