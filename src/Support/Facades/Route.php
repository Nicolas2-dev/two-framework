<?php

namespace Two\Support\Facades;

/**
 * @see \Two\Routing\Router
 */
class Route extends Facade
{
    
    /**
     * Obtenez le nom enregistré du composant.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'router'; }

}
