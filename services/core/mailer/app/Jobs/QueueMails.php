<?php

namespace App\Jobs;

use App\Providers\TenantModel;
use App\Providers\Mail;
use App\Providers\Tenant;
use Illuminate\Support\Facades\Mail as FacadesMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class QueueMails extends Job
{

    public $tenant;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(TenantModel $tenant)
    {
        $this->tenant = $tenant;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Tenant::setTenantConnection($this->tenant);
        $query = Mail::query()->whereNull('delivered_at')->where(function ($query) {
            return $query->whereNull('send_at')->orWhere('send_at', '<=', Carbon::now());
        });
        $mails = $query->get();
        $query->update([
            'delivered_at' => Carbon::now()
        ]);

        //send mails
        foreach ($mails as $mail) {
            try {
                FacadesMail::send('generator', ['content' => $mail->content], function ($message) use ($mail) {
                    $message->to($mail->email_to)
                        ->from($mail->email_from ?? 'noreply@' . env('APP_URL'))
                        ->subject($mail->subject);
                });
            } catch (\Exception $e) {
                Log::debug($e->getMessage() . ' - Stafflify "email not sent"');
                $mail->refresh();
                $mail->delivered_at = null;
                $mail->save();
            }
        }
    }
}
