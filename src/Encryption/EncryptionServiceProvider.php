<?php
/**
 * EncryptionServiceProvider - Implements a Service Provider for Encryption.
 *
 * @author Virgil-Adrian Teaca - virgil@giulianaeassociati.com
 * @version 3.0
 */

namespace Two\Encryption;

use Two\Encryption\Encrypter;

use Two\Support\ServiceProvider;


class EncryptionServiceProvider extends ServiceProvider
{
    /**
     * Register the Service Provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('encrypter', function($app)
        {
            return new Encrypter($app['config']['app.key']);
        });
    }
}

