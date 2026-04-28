<?php

namespace App\Mail\Master;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContractorMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $details;

    /**
     * Create a new message instance.
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

        return $this->view('emails.master.contractor_company.approve_rejection')
            ->subject(env('APP_NAME') . " - " . $this->details['mail_subject'])
            ->with("details", $this->details);
    }
}
