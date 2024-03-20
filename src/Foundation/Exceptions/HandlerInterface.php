<?php

namespace Two\Foundation\Exceptions;

use Two\Http\Request;


use Exception;


interface HandlerInterface
{

    /**
     * Signaler ou consigner une exception.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e);

    /**
     * Rendre une exception dans une réponse HTTP.
     *
     * @param  \Two\Http\Request  $request
     * @param  \Exception  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render(Request $request, Exception $e);

}
