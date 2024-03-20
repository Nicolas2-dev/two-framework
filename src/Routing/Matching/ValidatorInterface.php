<?php

namespace Two\Routing\Matching;

use Two\Http\Request;
use Two\Routing\Route;


interface ValidatorInterface
{
    /**
     * Validate a given rule against a route and request.
     *
     * @param  \Two\Routing\Route  $route
     * @param  \Two\Http\Request  $request
     * @return bool
     */
    public function matches(Route $route, Request $request);

}
