<?php

namespace Two\Support\Facades;

use Two\Support\Facades\Facade;


/**
 * @see \Two\Session\SessionManager
 * @see \Two\Session\Store
 */
class Session extends Facade
{
    /**
     * Return the Application instance.
     *
     * @return \Two\Pagination\Factory
     */
    public static function instance()
    {
        $accessor = static::getFacadeAccessor();

        return static::resolveFacadeInstance($accessor);
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'session'; }

}
