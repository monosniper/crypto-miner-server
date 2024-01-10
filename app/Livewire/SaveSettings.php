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
            if(is_array($value)) {
                foreach ($value as $k => $v) {
                    if(is_array($v)) {
                        foreach ($v as $k2 => $v2) {
                            $schema[] = TextInput::make($k.'.'.$k2)
                                ->label(__("settings.".$key.'.'.$k.'.'.$k2))
                                ->default($v2)
                                ->required()
                                ->suffixAction(
                                    Action::make('save')
                                        ->icon('heroicon-s-bookmark')
                                        ->action(function ($state) use($key, $k, $k2) {
                                            Setting::set($key.'.'.$k.'.'.$k2, $state);
                                            Setting::save();
                                        })
                                );
                        }
                    } else {
                        $schema[] = TextInput::make($k)
                            ->label(__("settings.".$key.".".$k))
                            ->default($v)
                            ->required()
                            ->suffixAction(
                                Action::make('save')
                                    ->icon('heroicon-s-bookmark')
                                    ->action(function ($state) use($key, $k) {
                                        Setting::set($key.'.'.$k, $state);
                                        Setting::save();
                                    })
                            );
                    }
                }
            } else {
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
