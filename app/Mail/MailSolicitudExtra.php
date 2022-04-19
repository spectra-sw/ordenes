<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailSolicitudExtra extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    public $e;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details,$e)
    {
        //
        $this->details = $details;
        $this->e = $e;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Solicitud de horas extras')
                    ->view('emails.solicitudExtra');
    }
}

