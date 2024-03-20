<?php

namespace Two\Auth;


interface UserProviderInterface
{
    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $identifier
     * @return \Two\Auth\UserInterface|null
     */
    public function retrieveById($identifier);

    /**
     * Retrieve a user by by their unique identifier and "remember me" token.
     *
     * @param  mixed   $identifier
     * @param  string  $token
     * @return \Two\Auth\UserInterface|null
     */
    public function retrieveByToken($identifier, $token);

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  \Two\Auth\UserInterface  $user
     * @param  string  $token
     * @return void
     */
    public function updateRememberToken(UserInterface $user, $token);

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Two\Auth\UserInterface|null
     */
    public function retrieveByCredentials(array $credentials);

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Two\Auth\UserInterface  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(UserInterface $user, array $credentials);

}
