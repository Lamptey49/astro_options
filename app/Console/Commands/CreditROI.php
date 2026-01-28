<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreditROI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:credit-r-o-i';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Investment::where('status','active')
        ->whereDate('end_date','<=',now())
        ->get()
        ->each(function($inv){
            $inv->user->increment('balance',$inv->amount + $inv->profit);
            $inv->update(['status'=>'completed']);
        });
    }

}
