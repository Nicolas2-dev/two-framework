<?php

namespace Two\Support\Facades;

use Two\Support\Facades\Facade;

/**
 * @see \Two\Language\Language
 * @see \Two\Language\LanguageManager
 */
class Language extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'language'; }

}
