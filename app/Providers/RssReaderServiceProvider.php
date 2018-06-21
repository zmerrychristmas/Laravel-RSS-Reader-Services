<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\RssReader as RssReader;

class RssReaderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(RssReader::class, function ($app) {
            return new RssReader();
        });
    }
}
