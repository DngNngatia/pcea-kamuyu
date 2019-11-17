<?php

namespace App\Observers;

use App\Data\Models\Quote;
use App\User;
use ExponentPhpSDK\Exceptions\ExpoException;
use ExponentPhpSDK\Expo;
use mysql_xdevapi\Exception;

class QuoteObserver
{
    /**
     * Handle the quote "created" event.
     *
     * @param \App\Data\Models\Quote $quote
     * @return void
     */
    public function created(Quote $quote)
    {
        $users = User::all();
        foreach ($users as $user) {
            try{
                $expo = Expo::normalSetup();
                $notification = ['body' => 'hey'];
//                $expo->notify($user->id, $notification);
            }catch (ExpoException $e){
//                $expo = Expo::normalSetup();
//                $expo->subscribe($user->id, $user->device_token);
//                $notification = ['body' => 'hey'];
//                $expo->notify($user->id, $notification);
            }

        }
    }

    /**
     * Handle the quote "updated" event.
     *
     * @param \App\Data\Models\Quote $quote
     * @return void
     */
    public function updated(Quote $quote)
    {
        $users = User::get();
        foreach ($users as $user) {
            try{
                $expo = Expo::normalSetup();
                $notification = ['body' => $quote->user->first_name.' uploaded a new quote', 'sound' => 'default'];
                $expo->notify($user->id, $notification);
            }catch (Exception $e){
                $expo = Expo::normalSetup();
                $expo->subscribe($user->id, $user->device_token);
                $notification = ['body' => $quote->user->first_name.' uploaded a new quote', 'sound' => 'default',];
                $expo->notify($user->id, $notification);
            }
        }
    }

    /**
     * Handle the quote "deleted" event.
     *
     * @param \App\Data\Models\Quote $quote
     * @return void
     */
    public function deleted(Quote $quote)
    {
        //
    }

    /**
     * Handle the quote "restored" event.
     *
     * @param \App\Data\Models\Quote $quote
     * @return void
     */
    public function restored(Quote $quote)
    {
        //
    }

    /**
     * Handle the quote "force deleted" event.
     *
     * @param \App\Data\Models\Quote $quote
     * @return void
     */
    public function forceDeleted(Quote $quote)
    {
        //
    }
}
