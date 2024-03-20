<?php

namespace Two\Foundation\Http\Middleware;

use Two\Foundation\Application;

use Symfony\Component\HttpKernel\Exception\HttpException;

use Closure;


class CheckForMaintenanceMode
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
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function handle($request, Closure $next)
    {
        if ($this->app->isDownForMaintenance()) {
            throw new HttpException(503);
        }

        return $next($request);
    }
}
