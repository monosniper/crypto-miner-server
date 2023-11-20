<?php

namespace App\Livewire;

use anlutro\LaravelSettings\Facades\Setting;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithHeaderActions;
use Livewire\Component;

class SaveSettings extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        $schema = [];

        foreach (Setting::all() as $key => $value) {
            $schema[] = TextInput::make($key)
                ->label(__("settings.".$key))
                ->default($value)
                ->required()
                ->suffixAction(
                    Action::make('save')
                        ->icon('heroicon-s-bookmark')
                        ->action(function ($state) use($key) {
                            Setting::set($key, $state);
                            Setting::save();
                        })
                );
        }

        return $form
            ->schema($schema)
            ->statePath('data');
    }

    public function save(): void
    {
        dd($this->form->getState());
    }

    public function render()
    {
        return view('livewire.save-settings');
    }
}
