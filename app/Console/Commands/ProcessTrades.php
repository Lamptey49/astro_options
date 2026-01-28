<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Trade;
use App\Models\TradingPair;
use App\Services\MarketService;

class ProcessTrades extends Command
{
    protected $signature = 'trades:process';
    protected $description = 'Simulate price movement and close trades';
    



public function handle()
{
    $trades = Trade::where('status', 'open')->get();

    foreach ($trades as $trade) {
        $price = MarketService::price($trade->pair);

        if ($trade->side === 'buy') {
            if ($trade->stop_loss && $price <= $trade->stop_loss) {
                $this->close($trade, $price);
            }
            if ($trade->take_profit && $price >= $trade->take_profit) {
                $this->close($trade, $price);
            }
        } else {
            if ($trade->stop_loss && $price >= $trade->stop_loss) {
                $this->close($trade, $price);
            }
            if ($trade->take_profit && $price <= $trade->take_profit) {
                $this->close($trade, $price);
            }
        }
    }
}

private function close($trade, $price)
{
    $pnl = $trade->side === 'buy'
        ? ($price - $trade->entry_price) * $trade->amount
        : ($trade->entry_price - $price) * $trade->amount;

    $trade->update([
        'exit_price' => $price,
        'pnl' => $pnl,
        'status' => 'closed',
        'closed_at' => now()
    ]);

    $trade->wallet->increment('balance', $pnl);
}

}

