<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;

class resetAdministratorPassword extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $reset_token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $reset_token)
    {
        $this->user = $user;
        $this->reset_token = $reset_token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.reset_administrator_password', ['user' => $this->user, 'reset_token' => $this->reset_token]);
    }
}
