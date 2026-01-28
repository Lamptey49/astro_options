<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\InvestmentPlan;
use App\Models\User;

class UserInvestment extends Model
{
    protected $fillable = [
        'user_id',
        'investment_plan_id',
        'amount',
        'expected_return',
        'start_date',
        'end_date',
        'status'
    ];

    public function plan()
    {
        return $this->belongsTo(InvestmentPlan::class,'investment_plan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function getProgressAttribute()
    {
        $start = Carbon::parse($this->start_date);
        $end   = Carbon::parse($this->end_date);
        $now   = now();

        if ($now->greaterThanOrEqualTo($end)) {
            return 100;
        }

        $total = $start->diffInSeconds($end);
        $elapsed = $start->diffInSeconds($now);

        return round(($elapsed / $total) * 100);
    }

}

