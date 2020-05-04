<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Console\Commands\AutoupdateXml;
use App\Console\Commands\TempArr;
use App\Console\Commands\AudDownbackup;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
       Commands\AutoupdateXml::class,
       Commands\TempArr::class,
		Commands\AudDownbackup::class,

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
		 //$schedule->command(AutoupdateXml::class)->dailyAt('20:01')->withoutOverlapping();
		 //$schedule->command(AutoupdateXml::class);
		//$schedule->command(AutoupdateXml::class)->everyMinute();

		//бэкап для автообновления
		$schedule->command('command:auddown')->dailyAt('20:30');

		$schedule->command('command:mtac')->dailyAt('21:10');
             $schedule->command('command:audxml')
				 			->timezone('Europe/Kiev')
                            ->between('21:20', '23:55');

    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}