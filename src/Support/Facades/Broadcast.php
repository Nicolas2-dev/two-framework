<?php

namespace Two\Support\Facades;

use Two\Broadcasting\FactoryInterface as BroadcastingFactory;


/**
 * @see \Two\Broadcasting\FactoryInterface
 */
class Broadcast extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return BroadcastingFactory::class;
    }
}
