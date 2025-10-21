<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyAccountMail extends Mailable
{
    use Queueable, SerializesModels;

    public $val;

    public function __construct($val)
    {
        $this->val = $val;
    }

    public function build()
    {
        return $this->subject('Verify your AgroConnect account')
                    ->view('emails.verify');
    }
}
