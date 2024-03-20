<?php

namespace Two\Auth\Access;

use Two\Auth\Access\Response;
use Two\Auth\Access\UnAuthorizedException;


trait HandlesAuthorizationTrait
{
    /**
     * Create a new access response.
     *
     * @param  string|null  $message
     * @return \Two\Auth\Access\Response
     */
    protected function allow($message = null)
    {
        return new Response($message);
    }

    /**
     * Throws an unauthorized exception.
     *
     * @param  string  $message
     * @return void
     *
     * @throws \Two\Auth\Access\UnauthorizedException
     */
    protected function deny($message = null)
    {
        $message = $message ?: __d('Two', 'This action is unauthorized.');

        throw new UnAuthorizedException($message);
    }
}
