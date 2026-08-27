<?php

namespace App\Console;

use App\Console\Commands\AppInit;
use App\Console\Commands\MigrateAll;
use App\Console\Commands\MigrateFresh;
use App\Console\Commands\WebSocketServer;
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
        AppInit::class,
        WebSocketServer::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //
    }
}
