<?php

namespace App\Console\Commands;

use App\Http\Controllers\Controller;
use App\Providers\Tenant;
use App\Providers\TenantModel;
use Illuminate\Console\Command;
use Illuminate\Http\Request;


class UserAdd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:add {email} {tenantid}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add user to system';

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
        $email = $this->argument('email');
        $tenant = $this->argument('tenantid');

        //set connection
        $model = TenantModel::query()->where('id', $tenant)->first();
        Tenant::setTenantConnection($model);

        //fake request
        $request = new Request([
            'email' => $email
        ]);

        //run request
        $response = Controller::put($request);
        dd($response);
    }
}
