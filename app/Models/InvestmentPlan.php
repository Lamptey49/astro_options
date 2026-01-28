<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvestmentPlan extends Model
{
    protected $fillable = [
        'name',
        'min_amount',
        'max_amount',
        'duration_days',
        'roi_percent',
        'is_active'
    ];

    public function investments()
    {
        return $this->hasMany(UserInvestment::class);
    }
}


