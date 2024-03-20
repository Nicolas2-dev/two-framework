<?php

namespace Two\Localization;

use Two\Localization\LanguageManager;
use Two\Support\ServiceProvider;


class LocalizationServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the Provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;


    /**
     * Register the Service Provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('language', function($app)
        {
            return new LanguageManager($app, $app['config']['app.locale']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('language');
    }
}
