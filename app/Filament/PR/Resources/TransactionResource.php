<?php

namespace App\Filament\PR\Resources;

use App\Filament\PR\Resources\TransactionResource\Pages;
use App\Filament\PR\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Пользователь')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Сумма')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Описание')
                ->formatStateUsing(fn (string $state): string => __($state)),
                Tables\Columns\TextColumn::make('type')
                    ->label('Тип')
                    ->formatStateUsing(fn (string $state): string => __("transactions.types.{$state}"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('purchase_type')
                    ->label('Тип покупки')
                    ->formatStateUsing(fn (string $state): string => __("transactions.purchase_types.{$state}"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Тип')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        Transaction::COMPLETED => 'success',
                        Transaction::FAILED => 'danger',
                        Transaction::PENDING => 'warning',
                    })
                    ->formatStateUsing(fn (string $state): string => __("transactions.statuses.{$state}"))
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([])
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
            'index' => Pages\ListTransactions::route('/'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
