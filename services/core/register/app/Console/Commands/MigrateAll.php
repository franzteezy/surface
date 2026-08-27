<?php

namespace App\Console\Commands;

use App\Providers\Tenant;
use App\Providers\TenantModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class MigrateAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Override migrate fresh for not replacing tables from other modules';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        TenantModel::chunk(200, function ($tenants) {
            foreach ($tenants as $tenant) {
                //set connection for database
                Config::set('database.connections.mysql.host', $tenant->ip_address);
                Config::set('database.connections.mysql.database', $tenant->database_name);
                Config::set('database.connections.mysql.password', $tenant->password);
                DB::purge();
                $this->call('migrate');
            }
        });
    }
}
