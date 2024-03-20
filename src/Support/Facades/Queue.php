<?php 

namespace Two\Support\Facades;

/**
 * @see \Two\Queue\QueueManager
 * @see \Two\Queue\Queue
 */
class Queue extends Facade
{

    /**
    * Get the registered name of the component.
    *
    * @return string
    */
    protected static function getFacadeAccessor() { return 'queue'; }

}
