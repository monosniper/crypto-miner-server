<?php

namespace App\Filament\Rows;

use App\Enums\CallStatus;
use App\Models\Call;
use App\Models\User;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Illuminate\View\View;

class CallRow
{
    static public function make(): array
    {
        return [
            TextColumn::make('user')
                ->label('Номер')
                ->icon(fn (Call $record): string => $record->user->country_code ? 'icon-' . mb_strtolower($record->user->country_code) : '')
                ->formatStateUsing(fn (User $state): View => view(
                    'filament.columns.tel',
                    ['state' => $state],
                ))
                ->searchable(),
            TextColumn::make('comment')
                ->label('Комментарий')
                ->limit(30)
                ->html()
                ->searchable(),
            TextInputColumn::make('amount')
                ->label('Сумма донатов')
                ->type('number')
                ->sortable(),
            SelectColumn::make('status')
                ->label('Статус')
                ->width(150)
                ->options([
                    CallStatus::NOT_CALLED->value => __("call.statuses.".CallStatus::NOT_CALLED->value),
                    CallStatus::CALLED->value => __("call.statuses.".CallStatus::CALLED->value),
                    CallStatus::NOT_ACCEPTED->value => __("call.statuses.".CallStatus::NOT_ACCEPTED->value),
                ]),
        ];
    }
}
