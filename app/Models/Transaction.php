<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
   protected $fillable = [
        'user_id',
        'type',
        'method',
        'crypto',
        'tx_hash',
        'amount',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
     public function isPending(): bool
    {
        return $this->status === 'pending';
    }
}


