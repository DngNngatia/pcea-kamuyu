<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendQuoteEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $quote;

    /**
     * SendQuoteEmail constructor.
     * @param $quote
     */
    public function __construct($quote)
    {
        $this->quote = $quote;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('quote');
    }
}
