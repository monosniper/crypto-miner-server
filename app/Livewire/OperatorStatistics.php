<?php

namespace App\Livewire;

use App\Models\User;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Livewire\Component;

class OperatorStatistics extends Component implements HasForms, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->state([
                'operators' => User::operators()->get()
            ])
            ->schema([
                RepeatableEntry::make('operators')
                    ->label('Операторы')
                    ->schema([
                        TextEntry::make('name'),
                    ])
            ]);
    }
}
