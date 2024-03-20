<?php

namespace Two\Foundation\Auth;

use Two\Http\Request;

use Two\Support\Facades\App;
use Two\Support\Facades\Redirect;


trait ThrottlesLoginsTrait
{
    /**
     * Determine if the user has too many failed login attempts.
     *
     * @param  \Two\Http\Request  $request
     * @return bool
     */
    protected function hasTooManyLoginAttempts(Request $request)
    {
        $rateLimiter = App::make('Two\Cache\RateLimiter');

        return $rateLimiter->tooManyAttempts(
            $this->getThrottleKey($request),
            $this->maxLoginAttempts(),
            $this->lockoutTime() / 60
        );
    }

    /**
     * Increment the login attempts for the user.
     *
     * @param  \Two\Http\Request  $request
     * @return int
     */
    protected function incrementLoginAttempts(Request $request)
    {
        $rateLimiter = App::make('Two\Cache\RateLimiter');

        $rateLimiter->hit($this->getThrottleKey($request));
    }

    /**
     * Determine how many retries are left for the user.
     *
     * @param  \Two\Http\Request  $request
     * @return int
     */
    protected function retriesLeft(Request $request)
    {
        $rateLimiter = App::make('Two\Cache\RateLimiter');

        $attempts = $rateLimiter->attempts($this->getThrottleKey($request));

        return $this->maxLoginAttempts() - $attempts + 1;
    }

    /**
     * Redirect the user after determining they are locked out.
     *
     * @param  \Two\Http\Request  $request
     * @return \Two\Http\RedirectResponse
     */
    protected function sendLockoutResponse(Request $request)
    {
        $rateLimiter = App::make('Two\Cache\RateLimiter');

        $seconds = $rateLimiter->availableIn($this->getThrottleKey($request));

        return Redirect::back()
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors(array(
                $this->loginUsername() => $this->getLockoutErrorMessage($seconds),
            ));
    }

    /**
     * Get the login lockout error message.
     *
     * @param  int  $seconds
     * @return string
     */
    protected function getLockoutErrorMessage($seconds)
    {
        return __d('Two', 'Too many login attempts. Please try again in {0} seconds.', $seconds);
    }

    /**
     * Clear the login locks for the given user credentials.
     *
     * @param  \Two\Http\Request  $request
     * @return void
     */
    protected function clearLoginAttempts(Request $request)
    {
        $rateLimiter = App::make('Two\Cache\RateLimiter');

        $rateLimiter->clear($this->getThrottleKey($request));
    }

    /**
     * Get the throttle key for the given request.
     *
     * @param  \Two\Http\Request  $request
     * @return string
     */
    protected function getThrottleKey(Request $request)
    {
        return mb_strtolower($request->input($this->loginUsername())) .'|' .$request->ip();
    }

    /**
     * Get the maximum number of login attempts for delaying further attempts.
     *
     * @return int
     */
    protected function maxLoginAttempts()
    {
        return property_exists($this, 'maxLoginAttempts') ? $this->maxLoginAttempts : 5;
    }

    /**
     * The number of seconds to delay further login attempts.
     *
     * @return int
     */
    protected function lockoutTime()
    {
        return property_exists($this, 'lockoutTime') ? $this->lockoutTime : 60;
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function loginUsername()
    {
        return property_exists($this, 'username') ? $this->username : 'email';
    }
}
