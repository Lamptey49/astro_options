<?php
namespace App\Console;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array<int, class-string<\Illuminate\Console\Command>>
     */
    protected $commands = [
        Commands\CompleteInvestments::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule($schedule)
    {
        $schedule->command('investments:complete')->daily();
        $schedule->command('trades:process')->everyMinute();
        $schedule->command('trades:monitor')->everyMinute();
    } 
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\SetLocale::class,
        ],
    ];
}
