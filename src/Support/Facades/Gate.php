<?php

namespace Two\Support\Facades;

/**
 * @see \Two\Auth\Access\GateInterface
 */
class Gate extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Two\Auth\Access\GateInterface';
    }
}
