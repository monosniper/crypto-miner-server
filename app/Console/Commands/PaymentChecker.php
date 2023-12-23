<?php

namespace App\Console\Commands;

use App\Models\Transaction;
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
        $response = Http::withHeader('x-api-key', env('NOWPAYMENTS_API_KEY'))
            ->get('https://api.nowpayments.io/v1/payment/5724001925');

        $this->info($response->body());
//        $transactions = Transaction::waiting()->get();
//
//        foreach ($transactions as $transaction) {
//
//        }
    }
}
