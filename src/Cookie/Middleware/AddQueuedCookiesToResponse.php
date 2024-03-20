<?php

namespace Two\Cookie\Middleware;

use Two\Foundation\Application;

use Closure;


class AddQueuedCookiesToResponse
{
    /**
     * The cookie jar instance.
     *
     * @var \Two\Cookie\CookieJar
     */
    protected $cookies;

    /**
     * Create a new CookieQueue instance.
     *
     * @param  \Two\Foundation\Application  $app
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->cookies = $app['cookie'];
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Two\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        foreach ($this->cookies->getQueuedCookies() as $cookie) {
            $response->headers->setCookie($cookie);
        }

        return $response;
    }
}
