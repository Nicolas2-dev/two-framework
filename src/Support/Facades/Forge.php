<?php

namespace Two\Support\Facades;


/**
 * @see \Two\Foundation\Forge
 */
class Forge extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'forge'; }

}
