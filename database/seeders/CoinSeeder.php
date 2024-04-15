<?php

namespace Database\Seeders;

use App\Models\Coin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coins = [
            ['name' => 'Tether', 'slug' => 'USDT'],

            ['name' => 'BTC', 'slug' => 'BTC'],
            ['name' => 'ETH', 'slug' => 'ETH'],
            ['name' => 'BNB', 'slug' => 'BNB'],
            ['name' => 'XRP', 'slug' => 'XRP'],
            ['name' => 'USDC', 'slug' => 'USDC'],
            ['name' => 'Solana', 'slug' => 'SOL'],
            ['name' => 'Cardano', 'slug' => 'ADA'],
            ['name' => 'Dogecoin', 'slug' => 'DOGE'],
            ['name' => 'TRON', 'slug' => 'TRX'],
            ['name' => 'Toncoin', 'slug' => 'TON'],
            ['name' => 'Dai', 'slug' => 'DAI'],
            ['name' => 'Polygon', 'slug' => 'MATIC'],
            ['name' => 'Polkadot', 'slug' => 'DOT'],
            ['name' => 'Litecoin', 'slug' => 'LTC'],
            ['name' => 'Wrapped Bitcoin', 'slug' => 'WBTC'],
            ['name' => 'Stellar', 'slug' => 'XLM'],
        ];

        foreach ($coins as $coin) {
            Coin::create($coin);
        }
    }
}
