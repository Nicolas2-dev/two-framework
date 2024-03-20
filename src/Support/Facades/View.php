<?php

namespace Two\Support\Facades;

use Two\Support\Facades\Facade;


/**
 * @see \Two\View\Factory
 * @see \Two\View\View
 */
class View extends Facade
{

    /**
     * Obtenez le nom enregistré du composant.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'view'; }

}
