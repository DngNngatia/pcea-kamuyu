<?php

namespace App\Console\Commands;

use App\Data\Models\Event;
use App\User;
use Carbon\Carbon;
use ExponentPhpSDK\Expo;
use Illuminate\Console\Command;

class NotifyUpComingEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:event';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $events = Event::where('start_time', '>=', Carbon::now()->subDay())->get();
        foreach ($events as $event) {
            $users = User::where('church_id', $event->church_id)->get();
            foreach ($users as $user){
                $expo = Expo::normalSetup();
                $notification = ['body' => $event->message, 'sound' => 'default',];
                $expo->notify($event->title, $notification);
            }
        }
    }
}
