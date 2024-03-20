<?php

namespace Two\Http\Middleware;

use Closure;


class FrameGuard
{
    /**
     * Handle the given request and get the response.
     *
     * @param  \Two\Http\Request  $request
     * @param  \Closure  $next
     * @return \Two\Http\Response
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'SAMEORIGIN', false);

        return $response;
    }
}
