<?php

namespace App\Mail;

use App\Models\RegistrationToken as ModelsRegistrationToken;
use App\Models\Users\RegistrationToken;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class RegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The registration instance.
     *
     * @var RegistrationToken
     */
    public $token;

    /**
     * Create a new message instance.
     *
     * @param RegistrationToken $token
     * @return void
     */
    public function __construct(ModelsRegistrationToken $token)
    {
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreply@stafflify.com', 'Stafflify')->view('mails.register');
    }
}
