<?php

namespace Two\Queue\Connectors;

use Two\Queue\Connectors\ConnectorInterface;
use Two\Queue\Queues\SyncQueue;


class SyncConnector implements ConnectorInterface
{

    /**
     * Establish a queue connection.
     *
     * @param  array  $config
     * @return \Two\Queue\Contracts\QueueInterface
     */
    public function connect(array $config)
    {
        return new SyncQueue;
    }

}
