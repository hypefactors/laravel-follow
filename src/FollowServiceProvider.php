<?php

namespace Hypefactors\Laravel\Follow;

use Illuminate\Support\ServiceProvider;

class FollowServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            // Publish migrations
            $this->publishes([
                realpath(__DIR__.'/../database/migrations') => database_path('migrations'),
            ], 'hypefactors:follow.migrations');

            // Load migrations
            $this->loadMigrationsFrom(
                realpath(__DIR__.'/../database/migrations')
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
    }
}
