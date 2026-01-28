<?php
namespace App\Models;

use App\Http\Controllers\WithdrawalController;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'method',
        'wallet_address',
        'bank_name',
        'account_number',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
