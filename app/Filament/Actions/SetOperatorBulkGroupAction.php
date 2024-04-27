<?php

namespace App\Filament\Actions;

use App\Models\User;
use Carbon\Carbon;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Illuminate\Database\Eloquent\Collection;

class SetOperatorBulkGroupAction
{
    static public function make($isHot = true, $isCall = true): BulkActionGroup {
        return BulkActionGroup::make([
            ...array_map(function (array $operator) use($isHot, $isCall) {
                $full_name = $operator['first_name'] . ' ' . $operator['last_name']
                    . ( Carbon::parse($operator['created_at'])->diffInWeeks(Carbon::now()) < 1 ? ' (Новый)' : '' );

                return BulkAction::make('set_operator_'.($isHot ? 'hot' : 'cold').'_'.$operator['id'])
                    ->label($full_name)
                    ->requiresConfirmation()
                    ->action($isCall
                        ? fn (Collection $records) => $records->each->update([
                            'operator_id' => $operator['id'],
                            'isHot' => $isHot
                        ])
                        : function (Collection $records) use($operator, $isHot) {
                            foreach ($records as $record) {
                                $record->call()->updateOrCreate([
                                    'operator_id' => $operator['id'],
                                    'isHot' => $isHot
                                ]);
                            }
                        }
                    );
            }, User::operators()->get()->toArray()),
        ]);
    }
}
