<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MarketDataService;

class MarketController extends Controller
{
    public function candles(Request $request)
{
    $map = [
        '1m' => '1m',
        '5m' => '5m',
        '15m' => '15m',
        '1h' => '1h',
        '4h' => '4h',
        '1d' => '1d',
    ];

    $tf = $map[$request->tf] ?? '1m';

    $symbol = $request->symbol ?? 'BTCUSDT';

    // Binance example
    $url = "https://api.binance.com/api/v3/klines?symbol={$symbol}&interval={$tf}&limit=100";

    $data = json_decode(file_get_contents($url));

    return collect($data)->map(fn($c) => [
        'time' => intval($c[0] / 1000),
        'open' => (float)$c[1],
        'high' => (float)$c[2],
        'low' => (float)$c[3],
        'close' => (float)$c[4],
        'volume' => (float)$c[5],
    ]);
}
public function price($pair)
{
    $symbol = strtoupper(str_replace('/', '', $pair)); // BTCUSDT

    $price = Http::get("https://api.binance.com/api/v3/ticker/price", [
        'symbol' => $symbol
    ])->json('price');

    return response()->json(['price' => (float)$price]);
}

}
