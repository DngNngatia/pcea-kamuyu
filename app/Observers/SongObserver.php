<?php

namespace App\Observers;

use App\Data\Models\Song;
use App\User;
use ExponentPhpSDK\Expo;
use mysql_xdevapi\Exception;

class SongObserver
{
    /**
     * Handle the song "created" event.
     *
     * @param \App\Data\Models\Song $song
     * @return void
     */
    public function created(Song $song)
    {
        $users = User::all();
        foreach ($users as $user) {
            $expo = Expo::normalSetup();
            $expo->subscribe($user->id, $user->device_token);
            $notification = ['body' => $song->user->first_name.' uploaded a song','data' => 'songs', 'sound' => 'default',];
            $expo->notify((string)$user->id, $notification);
        }
    }

    /**
     * Handle the song "updated" event.
     *
     * @param \App\Data\Models\Song $song
     * @return void
     */
    public function updated(Song $song)
    {
        //
    }

    /**
     * Handle the song "deleted" event.
     *
     * @param \App\Data\Models\Song $song
     * @return void
     */
    public function deleted(Song $song)
    {
        //
    }

    /**
     * Handle the song "restored" event.
     *
     * @param \App\Data\Models\Song $song
     * @return void
     */
    public function restored(Song $song)
    {
        //
    }

    /**
     * Handle the song "force deleted" event.
     *
     * @param \App\Data\Models\Song $song
     * @return void
     */
    public function forceDeleted(Song $song)
    {
        //
    }
}
