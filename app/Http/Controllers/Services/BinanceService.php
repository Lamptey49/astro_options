<?php

namespace App\Http\Controllers\Services;

use Illuminate\Support\Facades\Http;

class BinanceService
{
    public static function getPrice($symbol)
    {
        $url = "https://api.binance.com/api/v3/ticker/price?symbol={$symbol}";

        $response = Http::get($url);

        if ($response->ok()) {
            return $response->json()['price'] ?? null;
        }

        return null;
    }
}

