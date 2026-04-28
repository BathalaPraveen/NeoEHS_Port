<?php

namespace App\Mail\PTW;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SWPIsolationEmail extends Mailable
{

    use Queueable,
        SerializesModels;

    protected $details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('emails.ptw.general.isolation')
            ->subject(env('APP_NAME') . " - ".$this->details['mail_subject'])
            ->with("details", $this->details);
    }
}
