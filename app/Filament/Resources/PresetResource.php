<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PresetResource\Pages;
use App\Models\ConfigurationField;
use App\Models\Preset;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PresetResource extends Resource
{
    protected static ?string $model = Preset::class;

    protected static ?string $navigationIcon = 'heroicon-o-server-stack';

    protected static ?string $navigationLabel = 'Пресеты';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Название')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('price')
                    ->label('Цена за месяц')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\Toggle::make('nft')
                    ->label('Может фармить НФТ')
                    ->required(),
                Forms\Components\Toggle::make('isHot')
                    ->label('Рекомендовано')
                    ->required(),
                ...array_map(function ($field) {
                    return Forms\Components\Select::make("configuration.{$field['slug']}")
                        ->label(__('configuration.fields.'.$field['slug']))
                        ->searchable(['slug'])
                        ->options(array_map(function ($option) {
                            return "{$option['title']} (\${$option['price']})";
                        }, $field['options']));
                }, array_filter(ConfigurationField::with('options')->get()->toArray(), fn ($field) => $field['slug'] !== 'type'))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Название')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Цена')
                    ->money()
                    ->sortable(),
                Tables\Columns\IconColumn::make('canFarmNft')
                    ->label('НФТ')
                    ->boolean(),
                Tables\Columns\IconColumn::make('isHot')
                    ->label('Рекомендовано')
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
                //
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
            'index' => Pages\ListPresets::route('/'),
            'create' => Pages\CreatePreset::route('/create'),
            'edit' => Pages\EditPreset::route('/{record}/edit'),
        ];
    }
}
