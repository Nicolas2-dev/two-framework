<?php

namespace Two\Routing\Matching;

use Two\Http\Request;
use Two\Routing\Route;


class SchemeValidator implements ValidatorInterface
{
    /**
     * Validate a given rule against a route and request.
     *
     * @param  \Two\Routing\Route  $route
     * @param  \Two\Http\Request  $request
     * @return bool
     */
    public function matches(Route $route, Request $request)
    {
        if ($route->httpOnly()) {
            return ! $request->secure();
        } else if ($route->secure()) {
            return $request->secure();
        }

        return true;
    }

}
