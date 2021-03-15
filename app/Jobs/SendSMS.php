<?php

namespace App\Jobs;

use AfricasTalking\SDK\AfricasTalking;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $number, $message;

    /**
     * SendSMS constructor.
     * @param $number
     * @param $message
     */
    public function __construct($number, $message)
    {
        $this->number = $number;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $AT = new AfricasTalking('DigiTours', '5ecfd712a1c997cc0a72bb6acf811643b8e0fe047a77da7639c46ccfb69c6b88');
        $sms = $AT->sms();
        $sms->send([
            'to' => $this->number,
            'message' => $this->message
        ]);
    }
}
