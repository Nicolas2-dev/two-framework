<?php

namespace Two\Support\Facades;

use Two\Support\Facades\Facade;


/**
 * @see \Two\Assets\AuthManager
 */
class Asset extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'assets'; }
}
