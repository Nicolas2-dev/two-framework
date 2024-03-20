<?php

namespace Two\Exception;

use Two\Exception\Handler as ExceptionHandler;

use Two\Support\ServiceProvider;


class ExceptionServiceProvider extends ServiceProvider
{
    /**
     * Enregistrez le fournisseur de services.
     *
     * @return void
     */
    public function register()
    {
        $this->app['exception'] = $this->app->share(function ($app)
        {
            return new ExceptionHandler($app);
        });
    }
}