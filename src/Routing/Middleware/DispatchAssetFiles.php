<?php

namespace Two\Routing\Middleware;

use Two\Foundation\Application;

use Closure;


class DispatchAssetFiles
{
    /**
     * The application implementation.
     *
     * @var \Two\Foundation\Application
     */
    protected $app;

    /**
     * Create a new middleware instance.
     *
     * @param  \Two\Foundation\Application  $app
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
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
        $dispatcher = $this->app['assets.dispatcher'];

        return $dispatcher->dispatch($request) ?: $next($request);
    }
}
