<?php

namespace App\Observers;

use App\Data\Models\Quote;
use App\User;
use ExponentPhpSDK\Expo;

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
        $users = User::get();
        foreach ($users as $user) {
            $expo = Expo::normalSetup();
            $expo->subscribe($user->name, $user->device_token);
            $notification = ['body' => $quote->quote, 'sound' => 'default',];
            $expo->notify($quote->user->name . 'posted a new quote', $notification);
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
            $expo = Expo::normalSetup();
            $expo->subscribe($user->name, $user->device_token);
            $notification = ['body' => $quote->quote, 'sound' => 'default',];
            $expo->notify($quote->user->name . 'updated a quote', $notification);
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
