<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
 use App\Models\TradingPair;
 
class TradingPairSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   

    public function run(): void
    {
        TradingPair::updateOrCreate(
            ['symbol' => 'BTC/USDT'],
            ['price' => 64000]
        );

        TradingPair::updateOrCreate(
            ['symbol' => 'ETH/USDT'],
            ['price' => 3200]
        );
    }

}
