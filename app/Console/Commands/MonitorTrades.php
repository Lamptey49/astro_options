<?php


namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Trade;
use App\Services\TradeService;
use App\Services\BinanceService;

class MonitorTrades extends Command
{
    protected $signature = 'trades:monitor';
    protected $description = 'Monitor open trades and trigger stop-loss / take-profit';

    public function handle()
    {
        $trades = Trade::where('status', 'open')->get();

        foreach ($trades as $trade) {
            $price = BinanceService::price($trade->pair);

            if (!$price) continue;

            // TAKE PROFIT
            if ($trade->take_profit && (
                ($trade->side === 'buy' && $price >= $trade->take_profit) ||
                ($trade->side === 'sell' && $price <= $trade->take_profit)
            )) {
                TradeService::closeTrade($trade, $price);
            }

            // STOP LOSS
            if ($trade->stop_loss && (
                ($trade->side === 'buy' && $price <= $trade->stop_loss) ||
                ($trade->side === 'sell' && $price >= $trade->stop_loss)
            )) {
                TradeService::closeTrade($trade, $price);
            }
        }

        return Command::SUCCESS;
    }
}
