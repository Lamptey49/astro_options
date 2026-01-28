<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MarketDataService
{
    public static function getPrice($symbol)
    {
        $response = Http::get(
            'https://api.binance.com/api/v3/ticker/price',
            ['symbol' => strtoupper($symbol)]
        );

        return $response->json()['price'] ?? null;
    }

    public static function getCandles($symbol, $interval = '1m', $limit = 50)
    {
        $response = Http::get(
            'https://api.binance.com/api/v3/klines',
            [
                'symbol' => strtoupper($symbol),
                'interval' => $interval,
                'limit' => $limit
            ]
        );

        return $response->json();
    }
}
