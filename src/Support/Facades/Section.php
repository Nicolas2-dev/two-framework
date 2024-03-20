<?php

namespace Two\Support\Facades;

use Two\Support\Facades\Facade;


/**
 * Class Section
 * @package Two\Support\Facades
 */
class Section extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'view.section'; }

}
