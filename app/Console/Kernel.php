<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\SSWBASTAdmin::class,
        Commands\SSWBASTFisik::class,
        Commands\AutoApproveBASTAdmin::class,
        Commands\AutoApproveBASTFisik::class,
        Commands\LateNotifBASTAdmin::class,
        Commands\LateNotifBASTFisik::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('ssw:bast_admin')->daily()->runInBackground();
        // $schedule->command('ssw:bast_fisik')->daily()->runInBackground();
        // $schedule->command('autoapprove:bast_admin')->daily()->runInBackground();
        // $schedule->command('autoapprove:bast_fisik')->daily()->runInBackground();
        // $schedule->command('latenotif:bast_admin')->daily()->runInBackground();
        // $schedule->command('latenotif:bast_fisik')->daily()->runInBackground();

        $schedule->command('ssw:bast_admin')->everyMinute()->runInBackground();
        $schedule->command('ssw:bast_fisik')->everyMinute()->runInBackground();
        $schedule->command('autoapprove:bast_admin')->everyMinute()->runInBackground();
        $schedule->command('autoapprove:bast_fisik')->everyMinute()->runInBackground();
        $schedule->command('latenotif:bast_admin')->everyMinute()->runInBackground();
        $schedule->command('latenotif:bast_fisik')->everyMinute()->runInBackground();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
