<?php

namespace Two\Localization\Middleware;

use Two\Foundation\Application;

use Closure;


class SetupLanguage
{

    /**
     * La mise en œuvre de l'application.
     *
     * @var \Two\Foundation\Application
     */
    protected $app;


    /**
     * Créez une nouvelle instance de middleware.
     *
     * @param  \Two\Foundation\Application  $app
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Traiter une demande entrante.
     *
     * @param  \Two\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Two\Http\Exception\PostTooLargeException
     */
    public function handle($request, Closure $next)
    {
        $this->updateLocale($request);

        return $next($request);
    }

    /**
     * Mettez à jour les paramètres régionaux de l'application.
     *
     * @param  \Two\Http\Request  $request
     * @return void
     */
    protected function updateLocale($request)
    {
        $session = $this->app['session'];

        if ($session->has('language')) {
            $locale = $session->get('language');
        } else {
            $locale = $request->cookie(PREFIX .'language', $this->app['config']['app.locale']);

            $session->set('language', $locale);
        }

        $this->app['language']->setLocale($locale);
    }
}
