<?php

namespace App\Filament\Resources;

use App\Enums\OrderMethod;
use App\Enums\OrderPurchaseType;
use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'Счета';

    protected static ?string $navigationGroup = 'Статистика';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Пользователь')
                    ->searchable(),
                TextColumn::make('type')
                    ->label('Тип')
                    ->formatStateUsing(fn (OrderType $state): string => __("orders.types.{$state->value}")),
                TextColumn::make('purchase_type')
                    ->label('Тип покупки')
                    ->formatStateUsing(fn (OrderPurchaseType $state): string => __("orders.purchase_types.{$state->value}")),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Сумма')
                    ->numeric()
                    ->money()
                    ->sortable(),
                TextColumn::make('method')
                    ->label('Способ оплаты')
                    ->formatStateUsing(fn (OrderMethod $state): string => __("orders.methods.{$state->value}")),
                TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        OrderStatus::COMPLETED->value => 'success',
                        OrderStatus::PENDING->value => 'gray',
                        OrderStatus::FAILED->value => 'danger',
                    })
                    ->formatStateUsing(fn (OrderStatus $state): string => __("orders.statuses.{$state->value}")),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Тип')
                    ->options([
                        OrderType::DONATE->value => __("orders.types." . OrderType::DONATE->value),
                        OrderType::PURCHASE->value => __("orders.types." . OrderType::PURCHASE->value),
                    ]),
                SelectFilter::make('purchase_type')
                    ->label('Тип покупки')
                    ->options([
                        OrderPurchaseType::SERVER->value => __("orders.purchase_types." . OrderPurchaseType::SERVER->value),
                        OrderPurchaseType::BALANCE->value => __("orders.purchase_types." . OrderPurchaseType::BALANCE->value),
                    ]),
                SelectFilter::make('status')
                    ->label('Статус')
                    ->options([
                        OrderStatus::COMPLETED->value => __("orders.statuses." . OrderStatus::COMPLETED->value),
                        OrderStatus::PENDING->value => __("orders.statuses." . OrderStatus::PENDING->value),
                        OrderStatus::FAILED->value => __("orders.statuses." . OrderStatus::FAILED->value),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
