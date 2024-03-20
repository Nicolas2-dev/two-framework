<?php

namespace Two\Queue\Connectors;

use Two\Database\ConnectionResolverInterface;
use Two\Queue\Connectors\ConnectorInterface;
use Two\Queue\Queues\DatabaseQueue;
use Two\Support\Arr;


class DatabaseConnector implements ConnectorInterface
{
    /**
     * Database connections.
     *
     * @var \Two\Database\ConnectionResolverInterface
     */
    protected $connections;

    /**
     * Create a new connector instance.
     *
     * @param  \Two\Database\ConnectionResolverInterface  $connections
     * @return void
     */
    public function __construct(ConnectionResolverInterface $connections)
    {
        $this->connections = $connections;
    }

    /**
     * Establish a queue connection.
     *
     * @param  array  $config
     * @return \Two\Contracts\Queue\Queue
     */
    public function connect(array $config)
    {
        $connection = Arr::get($config, 'connection');

        return new DatabaseQueue(
            $this->connections->connection($connection),

            $config['table'],
            $config['queue'],

            Arr::get($config, 'expire', 60)
        );
    }
}
