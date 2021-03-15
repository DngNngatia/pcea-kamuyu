<?php

namespace App\Console\Commands;

use App\Data\Models\Party;
use App\User;
use Carbon\Carbon;
use ExponentPhpSDK\Expo;
use Illuminate\Console\Command;

class UpcomingPartyNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:party';

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
        $parties = Party::whereDate('start_time', '>=', Carbon::now()->subDay())->get();
        foreach ($parties as $party) {
            $users = User::where('church_id', $party->church_id)->get();
            foreach ($users as $user) {
                $expo = Expo::normalSetup();
                $expo->subscribe($user->name, $user->device_token);
                $notification = ['body' => $party->message, 'sound' => 'default'];
                $expo->notify($party->title, $notification);
            }
        }
    }
}
