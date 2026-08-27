<?php

namespace App\Console;

use App\Console\Commands\AppInit;
use App\Console\Commands\MailProcess;
use App\Console\Commands\MigrateAll;
use App\Console\Commands\MigrateFresh;
use App\Providers\Mail;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        MigrateFresh::class,
        MigrateAll::class,
        MailProcess::class,
        AppInit::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('mail:process')->everyMinute()->runInBackground();
    }
}
