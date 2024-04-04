<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConfigurationGroupResource\Pages;
use App\Filament\Resources\ConfigurationGroupResource\RelationManagers;
use App\Models\ConfigurationGroup;
use App\Services\CacheService;
use Filament\Tables\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ConfigurationGroupResource extends Resource
{
    protected static ?string $model = ConfigurationGroup::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Группы';

    protected static ?string $navigationGroup = 'Конфигуратор';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('slug'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('slug')
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
            'index' => Pages\ManageConfigurationGroups::route('/'),
        ];
    }
}
