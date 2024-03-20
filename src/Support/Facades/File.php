<?php

namespace Two\Support\Facades;

/**
 * @see \Two\Filesystem\Filesystem
 */
class File extends Facade
{
    
    /**
     * Obtenez le nom enregistré du composant.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'files'; }

}
