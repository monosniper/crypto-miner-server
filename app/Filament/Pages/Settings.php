<?php

namespace App\Filament\Pages;

use anlutro\LaravelSettings\Facades\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Page;

class Settings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $view = 'filament.pages.settings';

    protected static ?string $title = 'Настройки';

    protected static ?string $navigationLabel = 'Настройки';



}
