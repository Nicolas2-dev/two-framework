<?php

namespace Two\Foundation\Providers;

use Two\Foundation\Forge;

use Two\Support\Composer;
use Two\Support\ServiceProvider;


class ConsoleSupportServiceProvider extends ServiceProvider
{
    /**
     * Indique si le chargement du fournisseur est différé.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Enregistrez le fournisseur de services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('composer', function($app)
        {
            return new Composer($app['files'], $app['path.base']);
        });

        $this->app->singleton('forge', function($app)
        {
           return new Forge($app);
        });

        // Enregistrez les fournisseurs de services supplémentaires.
        $this->app->register('Two\Console\ScheduleServiceProvider');
        $this->app->register('Two\Queue\ConsoleServiceProvider');
    }

    /**
     * Obtenez les services fournis par le fournisseur.
     *
     * @return array
     */
    public function provides()
    {
        return array('composer', 'forge');
    }

}
