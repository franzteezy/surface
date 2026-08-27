<?php

namespace App\Console\Commands;

use App\Jobs\QueueMails;
use App\Providers\Mail;
use App\Providers\Tenant;
use App\Providers\TenantModel;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail as FacadesMail;

class MailProcess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process all new emails and send them';

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
                //queue mail job for tenant
                dispatch(new QueueMails($tenant));
            }
        });
    }
}
