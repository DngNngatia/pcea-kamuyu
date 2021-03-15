<?php

namespace App\Console\Commands;

use App\User;
use ExponentPhpSDK\Exceptions\ExpoException;
use ExponentPhpSDK\Expo;
use Illuminate\Console\Command;

class DamnCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fuck:you';

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
        $users = User::get();
        foreach ($users as $user) {
            try{
                $expo = Expo::normalSetup();
                $notification = ['body' => 'fuck u uploaded a new quote', 'sound' => 'default'];
                $expo->notify((string)$user->id, $notification);
            }catch (ExpoException $e){
                $expo = Expo::normalSetup();
                $expo->subscribe($user->id, $user->device_token);
                $notification = ['body' => 'fuck u uploaded a new quote', 'sound' => 'default'];
                $expo->notify((string)$user->id, $notification);
            }

        }
    }
}
