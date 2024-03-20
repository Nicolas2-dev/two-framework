<?php

namespace Two\Routing\Assets;

use Two\Routing\Assets\AssetDispatcher;
use Two\Routing\Assets\AssetManager;
use Two\Support\ServiceProvider;


class AssetServiceProvider extends ServiceProvider
{

    /**
     * Register the Service Provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAssetManager();

        $this->registerAssetDispatcher();
    }

    /**
     * Register the Asset Manager instance.
     *
     * @return void
     */
    protected function registerAssetManager()
    {
        $this->app->singleton('assets', function ($app)
        {
            return new AssetManager($app['view']);
        });
    }

    /**
     * Register the Assets Dispatcher instance.
     *
     * @return void
     */
    protected function registerAssetDispatcher()
    {
        $this->app->singleton('assets.dispatcher', function ($app)
        {
            return new AssetDispatcher($app);
        });
    }
}
