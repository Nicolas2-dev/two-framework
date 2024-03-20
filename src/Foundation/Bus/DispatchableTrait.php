<?php

namespace Two\Foundation\Bus;

use Two\Foundation\Bus\PendingDispatch;


trait DispatchableTrait
{

    /**
     * Dispatch the job with the given arguments.
     *
     * @return \Two\Foundation\Bus\PendingDispatch
     */
    public static function dispatch()
    {
        $args = func_get_args();

        return new PendingDispatch(new static(...$args));
    }
}
