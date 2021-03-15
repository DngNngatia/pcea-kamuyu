<?php

namespace App\Jobs;

use App\Data\Models\Quote;
use App\Mail\SendQuoteEmail;
use ExponentPhpSDK\Exceptions\ExpoException;
use ExponentPhpSDK\Expo;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class QuoteUploaded implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $quote;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($quote)
    {
        $this->quote = $quote;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to(['derykowaynx@gmail.com'])->send(new SendQuoteEmail($this->quote));
        try {
            $expo = Expo::normalSetup();
            $notification = ['body' =>'fuck u', 'sound' => 'default'];
            $expo->notify((string)$this->quote->user->id, $notification);
        } catch (ExpoException $e) {
            $expo = Expo::normalSetup();
            $expo->subscribe($this->quote->user->id, $this->quote->user->device_token);
            $notification = ['body' => 'fuck u', 'sound' => 'default'];
            $expo->notify((string)$$this->quote->user->id, $notification);
        }
    }
}
