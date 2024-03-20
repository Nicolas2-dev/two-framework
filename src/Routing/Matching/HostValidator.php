<?php

namespace Two\Routing\Matching;

use Two\Http\Request;
use Two\Routing\Route;


class HostValidator implements ValidatorInterface
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
        $regex = $route->getCompiled()->getHostRegex();

        if (is_null($regex)) return true;

        return preg_match($regex, $request->getHost());
    }

}
