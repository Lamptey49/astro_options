<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Watchlist extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','trading_pair_id'];

    public function pair()
    {
        return $this->belongsTo(TradingPair::class,'trading_pair_id');
    }
}

