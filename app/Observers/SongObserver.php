<?php

namespace App\Observers;

use App\Data\Models\Song;
use App\User;
use ExponentPhpSDK\Expo;

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
        $users = User::get();
        foreach ($users as $user) {
            $expo = Expo::normalSetup();
            $notification = ['body' => $song->uploaded_by->name . ' uploaded a new song: ' . $song->title . ' by ' . $song->name, 'sound' => 'default',];
            $expo->notify($user->name . 'updated a quote', $notification);
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
