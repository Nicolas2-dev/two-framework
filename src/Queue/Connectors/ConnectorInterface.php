<?php

namespace Two\Queue\Connectors;


interface ConnectorInterface
{

    /**
     * Establish a queue connection.
     *
     * @param  array  $config
     * @return \Two\Queue\Contracts\QueueInterface
     */
    public function connect(array $config);

}
