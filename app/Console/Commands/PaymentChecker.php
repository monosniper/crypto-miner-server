<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use App\Models\UserServer;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class PaymentChecker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Проверяет все транзакции и выполняет условия завершенных';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $transactions = Transaction::waiting()->get();

        foreach ($transactions as $transaction) {
            $response = Http::withHeader('x-api-key', env('NOWPAYMENTS_API_KEY'))
                ->get('https://api.nowpayments.io/v1/payment/' . $transaction->payment_id);

            iF($response->ok()) {
                $payment = $response->json();

                if($payment['payment_status'] === Transaction::COMPLETED) {
                    $transaction->update(['status' => Transaction::COMPLETED]);

                    if($transaction->type === Transaction::PURCHASE) {
                        if($transaction->purchase_type === Transaction::SERVER) {
                            UserServer::create([
                                'user_id' => $transaction->user_id,
                                'server_id' => $transaction->purchase_id,
                            ]);

                            $this->info('User ' . $transaction->user_id . ' got server ' . $transaction->purchase_id);
                        } else if($transaction->purchase_type === Transaction::BALANCE) {
                            $wallet = $transaction->user->wallet;
                            $balance = $wallet->balance;
                            $balance['USDT'] += $transaction->amount;
                            $wallet->balance = $balance;
                            $wallet->save();

                            $this->info('User ' . $transaction->user_id . ' replenished balance for ' . $transaction->amount . ' USDT');
                        }else if($transaction->purchase_type === Transaction::RENEW_SERVER) {
                            $server = UserServer::find($transaction->purchase_id);
                            $server->activeUntil = Carbon::now()->addMonth();
                            $wallet->save();

                            $this->info('User ' . $transaction->user_id . ' renewed server ' . $server->name);
                        }
                    }
                }
            } else {
                $this->warn('Can\'t get payment with id: ' . $transaction->payment_id);
            }
        }
    }
}
