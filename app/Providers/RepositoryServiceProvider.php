<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\OutageRepository::class, \App\Repositories\OutageRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SubscriberRepository::class, \App\Repositories\SubscriberRepositoryEloquent::class);
        //:end-bindings:
    }
}
