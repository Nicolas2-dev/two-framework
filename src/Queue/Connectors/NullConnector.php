<?php

namespace Two\Queue\Connectors;

use Two\Queue\Connectors\ConnectorInterface;
use Two\Queue\Queues\NullQueue;


class NullConnector implements ConnectorInterface
{
    /**
     * Establish a queue connection.
     *
     * @param  array  $config
     * @return \Two\Contracts\Queue\Queue
     */
    public function connect(array $config)
    {
        return new NullQueue;
    }
}
