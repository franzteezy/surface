<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AppInit extends Command
{
    protected $signature = 'app:init';

    public function handle()
    {


        $this->call('migrate', ['--path' => '/database/shared_migrations/2022_05_31_062043_create_sessions_table.php']);
        $this->call('migrate', ['--path' => '/database/shared_migrations/2022_07_18_184354_create_tenant_users_table.php']);

        $updated = false;
        $tries = 0;
        //will try for 5 minutes before quitting
        while (!$updated || $tries === 30) {
            try {
                DB::connection('tenants')->getPdo();
                $this->call('migrate:all');
                $updated = true;
            } catch (\Exception $e) {
                print("Database could not connect - waiting 10 seconds to retry\n\r");
                sleep(10);
            }
            $tries++;
        }
    }
}
