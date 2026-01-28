<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradingPair extends Model
{
    use HasFactory;

    protected $fillable = [
        'symbol',
        'base_asset',
        'quote_asset',
        'source',
        'is_active',
        'binance_symbol',
        'icon'
    ];

}
