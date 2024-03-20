<?php

namespace Two\Filesystem;

use Two\Filesystem\Filesystem;

use Two\Support\ServiceProvider;


class FilesystemServiceProvider extends ServiceProvider
{

    /**
     * Enregistrez le fournisseur de services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('files', function()
        {
            return new Filesystem();
        });
    }

}
