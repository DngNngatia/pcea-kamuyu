<?php

namespace App\Providers;

use App\Data\Models\Quote;
use App\Data\Models\Song;
use App\Observers\QuoteObserver;
use App\Observers\SongObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Quote::observe(QuoteObserver::class);
        Song::observe(SongObserver::class);
    }
}
