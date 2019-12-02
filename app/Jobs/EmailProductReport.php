<?php

namespace App\Jobs;

use App\Mail\SendReport;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class EmailProductReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $path;

    /**
     * EmailProductReport constructor.
     * @param $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to(['derykowaynx@gmail.com'])->send(new SendReport($this->path));
    }
}
