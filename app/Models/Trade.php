<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    protected $fillable = [
        'user_id',
        'pair',
        'side',
        'amount',
        'entry_price',
        'mode',
        'stop_loss',
        'take_profit',
        'status',
        'opened_at',
        'closed_at',
        'profit'
    ];

    protected $casts = [
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    public function pair()
    {
        return $this->belongsTo(TradingPair::class, 'trading_pair_id');
    }
}
