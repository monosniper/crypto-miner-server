<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConfigurationOptionResource\Pages;
use App\Filament\Resources\ConfigurationOptionResource\RelationManagers;
use App\Models\ConfigurationOption;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ConfigurationOptionResource extends Resource
{
    protected static ?string $model = ConfigurationOption::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Опции';

    protected static ?string $navigationGroup = 'Конфигуратор';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title'),
                Forms\Components\TextInput::make('price')
                    ->numeric(),
                Forms\Components\Select::make('field_id')
                    ->label('Поле')
                    ->relationship(name: 'field', titleAttribute: 'slug')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('price')
                    ->money()
            ])
            ->filters([
                SelectFilter::make('field_id')
                    ->label('Поле')
                    ->relationship('field', 'slug')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ManageConfigurationOptions::route('/'),
        ];
    }
}
