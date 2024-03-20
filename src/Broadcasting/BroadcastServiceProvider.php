<?php

namespace Two\Broadcasting;

use Two\Broadcasting\BroadcastManager;

use Two\Support\ServiceProvider;


class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Two\Broadcasting\BroadcastManager', function ($app)
        {
            return new BroadcastManager($app);
        });

        $this->app->singleton('Two\Broadcasting\BroadcasterInterface', function ($app)
        {
            return $app->make('Two\Broadcasting\BroadcastManager')->connection();
        });

        $this->app->alias(
            'Two\Broadcasting\BroadcastManager', 'Two\Broadcasting\FactoryInterface'
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array(
            'Two\Broadcasting\BroadcastManager',
            'Two\Broadcasting\FactoryInterface',
            'Two\Broadcasting\BroadcasterInterface',
        );
    }
}
