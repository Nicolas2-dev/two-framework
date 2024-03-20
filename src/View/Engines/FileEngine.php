<?php

namespace Two\View\Engines;

use Two\View\Engines\EngineInterface;


class FileEngine implements EngineInterface
{
    /**
     * Get the evaluated contents of the view.
     *
     * @param  string  $path
     * @param  array   $data
     * @return string
     */
    public function get($path, array $data = array())
    {
        return file_get_contents($path);
    }
}
