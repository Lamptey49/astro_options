<?php 
namespace App\Http\Controllers\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Trade;

class TradeService
{
    public static function closeTrade(Trade $trade, float $exitPrice)
    {
        if ($trade->status === 'closed') return;

        // BUY trade
        if ($trade->side === 'buy') {
            $pnl = ($exitPrice - $trade->entry_price)
                * ($trade->amount / $trade->entry_price);
        }

        // SELL trade
        else {
            $pnl = ($trade->entry_price - $exitPrice)
                * ($trade->amount / $trade->entry_price);
        }

        $trade->update([
            'exit_price' => $exitPrice,
            'pnl' => $pnl,
            'status' => 'closed'
        ]);

        $wallet = $trade->user->wallet;

        // Return margin + PnL
        $credit = $trade->amount + $pnl;

        if ($trade->mode === 'live') {
            $wallet->increment('balance', $credit);
        } else {
            $wallet->increment('demo_balance', $credit);
        }
    }
}
