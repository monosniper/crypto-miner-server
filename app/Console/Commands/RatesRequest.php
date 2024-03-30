<?php

namespace App\Console\Commands;

use App\Models\Coin;
use App\Services\CacheService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Isolatable;
use Illuminate\Support\Facades\Cache;

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
    public function handle(): void
    {
        $client = new Client();
        $headers = [
            'authorization' => env('CRYPTOCOMPARE_API_KEY')
        ];

        $coins = Coin::all();

        foreach ($coins as $coin) {
            try {
                // Graph today
                $request = new Request('GET', "https://min-api.cryptocompare.com/data/v2/histohour?fsym=$coin->slug&tsym=USD&limit=23", $headers);
                $res = $client->sendAsync($request)->wait();
                info($res->getBody());
                $graph_today_data = json_decode($res->getBody())->Data->Data;

                $graph_today = [];

                foreach ($graph_today_data as $hour) {
                    $avg = ($hour->low + $hour->high) / 2;
                    $graph_today[] = $avg;
                }

                // Capacity & price
                $request = new Request('GET', "https://min-api.cryptocompare.com/data/pricemultifull?fsyms=$coin->slug&tsyms=USD", $headers);
                $res = $client->sendAsync($request)->wait();

                $slug = $coin->slug;

                $data = json_decode($res->getBody())->RAW->$slug->USD;

                $change = $data->CHANGEPCTDAY;
                $rate = $data->PRICE;

                // Save to coin
                $coin->graph_today = json_encode($graph_today);
                $coin->change = $change;
                $coin->rate = $rate;

                $coin->save();
            } catch (\Exception $err) {
                info("HELLLOOO");
                info($coin->slug);
            }
        }

        CacheService::save(CacheService::COINS);
    }
}
