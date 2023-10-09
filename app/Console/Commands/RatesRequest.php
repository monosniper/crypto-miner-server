<?php

namespace App\Console\Commands;

use App\Models\Coin;
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

        $coins = Coin::all();

        foreach ($coins as $coin) {
            $request = new Request('GET', "https://min-api.cryptocompare.com/data/v2/histohour?fsym=$coin->slug&tsym=USD&limit=23", $headers);
            $res = $client->sendAsync($request)->wait();

            $graph_data = json_decode($res->getBody())->Data->Data;

            $request = new Request('GET', "https://min-api.cryptocompare.com/data/pricemultifull?fsyms=$coin->slug&tsyms=USD", $headers);
            $res = $client->sendAsync($request)->wait();

            $slug = $coin->slug;
            $data = json_decode($res->getBody())->RAW->$slug->USD;

            $change = $data->CHANGEPCTDAY;
            $rate = $data->PRICE;

            $graph = [];

            foreach ($graph_data as $hour) {
                $avg = ($hour->low + $hour->high) / 2;
                $graph[] = $avg;
            }

            $coin->graph = json_encode($graph);
            $coin->change = $change;
            $coin->rate = $rate;

            $coin->save();
        }
    }
}
