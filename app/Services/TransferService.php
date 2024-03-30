<?php

namespace App\Services;

use App\Models\User;

class TransferService
{
    public function store($data): bool
    {
        $success = true;
        $user = User::where('name', $data['username'])->first();
        $amount = $data['amount'];

        if($user) {
            $amount = $amount - ($amount / 100 * setting('transfer_fee'));

            $wallet = auth()->user()->wallet;
            $balance = $wallet->balance;
            $balance['USDT'] -= $amount;
            $wallet->balance = $balance;
            $wallet->save();

            $user_wallet = $user->wallet;
            $user_balance = $user_wallet->balance;
            $user_balance['USDT'] += $amount;
            $user_wallet->balance = $user_balance;
            $user_wallet->save();
        } else $success = false;

        return $success;
    }
}
