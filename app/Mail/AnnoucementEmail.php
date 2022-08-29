<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AnnoucementEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $annoucment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($annoucment)
    {
        $this->annoucment = $annoucment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $annoucment = $this->annoucment;
        return $this->from(auth()->user()->email)->view('email_templates.annoucement_email', compact('annoucment'))->subject($annoucment['title']);
    }
}
