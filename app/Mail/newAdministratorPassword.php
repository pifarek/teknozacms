<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class newAdministratorPassword extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $new_password;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $new_password)
    {
        $this->user = $user;
        $this->new_password = $new_password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.new_administrator_password', ['user' => $this->user, 'new_password' => $this->new_password]);
    }
}
