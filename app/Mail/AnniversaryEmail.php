<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AnniversaryEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $anniversary;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($anniversary)
    {
        $this->anniversary = $anniversary;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $anniversary = $this->anniversary;
        return $this->view('email_templates.anniversary_email', compact('anniversary'))->with(['message' => $this])->subject('Happy Anniversary'." ".$anniversary->first_name);
    }
}
