<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Investment;

class CompleteInvestments extends Command
{
    protected $signature = 'investments:complete';
    protected $description = 'Complete matured investments';

    public function handle()
    {
        $investments = UserInvestment::where('status','active')
            ->where('end_date','<=',now())
            ->get();

        foreach($investments as $investment){
            $investment->user->increment('balance', $investment->expected_return);
            $investment->update(['status'=>'completed']);
        }
    }

}

