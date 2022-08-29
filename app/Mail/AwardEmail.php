<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AwardEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $award, $awardType;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($award, $awardType)
    {
        $this->award = $award;
        $this->awardType = $awardType;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $award= $this->award;
        $awardType= $this->awardType;
        return $this->view('email_templates.award_email', compact('award', 'awardType'))->subject('Congratulation');
    }
}
