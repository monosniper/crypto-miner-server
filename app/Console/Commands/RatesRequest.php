<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Isolatable;

class RatesRequest extends Command implements Isolatable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rates:request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Request cryptocurrency rates and data for graphics';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new Client();
        $headers = [
            'authorization' => env('CRYPTOCOMPARE_API_KEY')
        ];
        $request = new Request('GET', 'https://min-api.cryptocompare.com/data/v2/histohour?fsym=BTC&tsym=USD&limit=23', $headers);
        $res = $client->sendAsync($request)->wait();
        echo $res->getBody();
    }
}
