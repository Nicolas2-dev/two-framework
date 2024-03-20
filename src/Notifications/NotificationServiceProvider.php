<?php

namespace Two\Notifications;

use Two\Bus\DispatcherInterface as BusDispatcher;
use Two\Notifications\ChannelManager;
use Two\Support\ServiceProvider;


class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the Provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;


    /**
     * Register the Notifications plugin Service Provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('notifications', function ($app)
        {
            $bus = $app->make(BusDispatcher::class);

            return new ChannelManager($app, $app['events'], $bus);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('notifications');
    }
}
