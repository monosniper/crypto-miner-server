<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConfigurationFieldResource\Pages;
use App\Filament\Resources\ConfigurationFieldResource\RelationManagers;
use App\Models\ConfigurationField;
use App\Services\CacheService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Predis\Command\Argument\Search\SchemaFields\TextField;

class ConfigurationFieldResource extends Resource
{
    protected static ?string $model = ConfigurationField::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Поля';

    protected static ?string $navigationGroup = 'Конфигуратор';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('slug'),
                Forms\Components\Select::make('type')
                    ->options(ConfigurationField::TYPES),
                Forms\Components\Select::make('group_id')
                    ->label('Группа')
                    ->relationship(name: 'group', titleAttribute: 'slug')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\TextColumn::make('type')
            ])
            ->filters([
                SelectFilter::make('group_id')
                    ->label('Группа')
                    ->relationship('group', 'slug')
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->after(fn () => CacheService::save(CacheService::CONFIGURATION)),
                Tables\Actions\DeleteAction::make()
                    ->after(fn () => CacheService::save(CacheService::CONFIGURATION)),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->after(fn () => CacheService::save(CacheService::CONFIGURATION)),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageConfigurationFields::route('/'),
        ];
    }
}
