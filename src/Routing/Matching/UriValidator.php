<?php

namespace Two\Routing\Matching;

use Two\Http\Request;
use Two\Routing\Route;


class UriValidator implements ValidatorInterface
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
        $regex = $route->getCompiled()->getRegex();

        $path = ($request->path() == '/') ? '/' : '/' .$request->path();

        return preg_match($regex, rawurldecode($path));
    }

}
