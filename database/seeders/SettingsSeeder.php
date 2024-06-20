<?php

namespace Database\Seeders;

use anlutro\LaravelSettings\Facades\Setting;
use App\Models\Coin;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        Setting::set('telegram', 'https://www.google.com');
//        Setting::set('youtube', 'https://www.google.com');
//        Setting::set('facebook', 'https://www.google.com');
//        Setting::set('instagram', 'https://www.google.com');
//        Setting::set('tiktok', 'https://www.google.com');
//        Setting::set('withdraw_fee', 30);
//        Setting::set('convertation_fee', 1);
//        Setting::set('ref_percent', 10);
//        Setting::set('pr_percent', 30);
//        Setting::set('transfer_fee', 5);
//        Setting::set('transfer_min', 10);
//        Setting::set('coin_prices', [
//            Coin::where('slug', 'BTC')->first()->id =>   15,
//            Coin::where('slug', 'ETH')->first()->id =>   12,
//            Coin::where('slug', 'BNB')->first()->id =>   8,
//            Coin::where('slug', 'XRP')->first()->id =>   0,
//            Coin::where('slug', 'USDC')->first()->id =>  5,
//            Coin::where('slug', 'SOL')->first()->id =>   4,
//            Coin::where('slug', 'ADA')->first()->id =>   4,
//            Coin::where('slug', 'DOGE')->first()->id =>  5,
//            Coin::where('slug', 'TRX')->first()->id =>   8,
//            Coin::where('slug', 'TON')->first()->id =>   8,
//            Coin::where('slug', 'DAI')->first()->id =>   5,
//            Coin::where('slug', 'MATIC')->first()->id => 5,
//            Coin::where('slug', 'DOT')->first()->id =>   5,
//            Coin::where('slug', 'LTC')->first()->id =>   10,
//            Coin::where('slug', 'WBTC')->first()->id =>  15,
//            Coin::where('slug', 'XLM')->first()->id =>   0,
//        ]);

//        Setting::set('wallet_usdt', '');
//        Setting::set('landing_video', '');
//        Setting::set('how_video', '');

        Setting::save();
    }
}
