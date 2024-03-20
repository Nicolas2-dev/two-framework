<?php

namespace Two\Support\Facades;

use Two\Support\Facades\Facade;


/**
 * @see \Two\Foundation\Application
 */
class App extends Facade
{
    
    /**
     * Renvoie l'instance Application.
     *
     * @return \Two\Foundation\Application
     */
    public static function instance()
    {
        $accessor = static::getFacadeAccessor();

        return static::resolveFacadeInstance($accessor);
    }

    /**
     * Obtenez le nom enregistré du composant.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'app'; }
}
