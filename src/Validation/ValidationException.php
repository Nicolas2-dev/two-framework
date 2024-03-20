<?php

namespace Two\Validation;

use Two\Contracts\MessageProviderInterface;

use RuntimeException;


class ValidationException extends RuntimeException
{
    /**
     * The message provider implementation.
     *
     * @var \Two\Support\Contracts\MessageProviderInterface
     */
    protected $provider;

    /**
     * Create a new validation exception instance.
     *
     * @param  \Two\Support\MessageProvider  $provider
     * @return void
     */
    public function __construct(MessageProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Get the validation error message provider.
     *
     * @return \Two\Support\MessageBag
     */
    public function errors()
    {
        return $this->provider->getMessageBag();
    }

    /**
     * Get the validation error message provider.
     *
     * @return \Two\Support\MessageProviderInterface
     */
    public function getMessageProvider()
    {
        return $this->provider;
    }
}
