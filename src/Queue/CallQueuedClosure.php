<?php

namespace Two\Queue;

use Two\Encryption\Encrypter;
use Two\Queue\Job;


class CallQueuedClosure
{
    /**
     * The encrypter instance.
     *
     * @var \Two\Encryption\Encrypter  $crypt
     */
    protected $crypt;


    /**
     * Create a new queued Closure job.
     *
     * @param  \Two\Encryption\Encrypter  $crypt
     * @return void
     */
    public function __construct(Encrypter $crypt)
    {
        $this->crypt = $crypt;
    }

    /**
     * Fire the Closure based queue job.
     *
     * @param  \Two\Queue\Job  $job
     * @param  array  $data
     * @return void
     */
    public function call(Job $job, array $data)
    {
        $payload = $this->crypt->decrypt(
            $data['closure']
        );

        $closure = unserialize($payload);

        call_user_func($closure, $job);
    }
}
