<?php

namespace Two\View\Middleware;

use Two\Support\ViewErrorBag;

use Two\View\Factory as ViewFactory;

use Closure;


class ShareErrorsFromSession
{
    /**
     * The view factory implementation.
     *
     * @var \Two\Contracts\View\Factory
     */
    protected $view;

    /**
     * Create a new error binder instance.
     *
     * @param  \Two\View\Factory  $view
     * @return void
     */
    public function __construct(ViewFactory $view)
    {
        $this->view = $view;
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
        $this->view->share(
            'errors', $request->session()->get('errors', new ViewErrorBag())
        );

        return $next($request);
    }
}
