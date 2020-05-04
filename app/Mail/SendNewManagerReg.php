<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewManagerReg extends Mailable
{
    use Queueable, SerializesModels;

    public $director;
    public $company;
    public $user;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($director, $company, $user, $password)
    {
        $this->director = $director;
        $this->company = $company;
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $name_site = env('APP_NAME');
        return $this->subject('Вы добавили нового менеджера '.$name_site)->view('emails.providers.managers.sendNewManagerReg');
    }
}
