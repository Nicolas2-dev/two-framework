<?php

namespace Two\Support\Facades;

/**
 * @see \Two\View\Compilers\TemplateCompiler
 */
class Markdown extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return static::$app['view']->getEngineResolver()->resolve('markdown')->getCompiler();
    }

}
