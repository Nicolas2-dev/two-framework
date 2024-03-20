<?php

namespace Two\Bus;

use Two\Support\ServiceProvider;


class BusServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Two\Bus\Dispatcher', function ($app)
        {
            return new Dispatcher($app, function ($connection = null) use ($app)
            {
                return $app->make('queue')->connection($connection);
            });
        });

        $this->app->alias(
            'Two\Bus\Dispatcher', 'Two\Bus\DispatcherInterface'
        );

        $this->app->alias(
            'Two\Bus\Dispatcher', 'Two\Bus\QueueingDispatcherInterface'
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'Two\Bus\Dispatcher',
            'Two\Bus\DispatcherInterface',
            'Two\Bus\QueueingDispatcherInterface',
        ];
    }
}
