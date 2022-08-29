<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BirthdayEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $birthday;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($birthday)
    {
        $this->birthday = $birthday;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         $birthday= $this->birthday;
        return $this->view('email_templates.birthday_email', compact('birthday'))->with(['message' => $this])->subject('Happy Birthday'." ".$birthday->first_name);
    }
}
