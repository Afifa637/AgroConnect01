<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $role;
    public $email;

    public function __construct($role, $email)
    {
        $this->role = $role;
        $this->email = $email;
    }

    public function build()
    {
        return $this->subject('AgroConnect - Password Reset Link')
                    ->view('home.pw_change_mail');
    }
}
