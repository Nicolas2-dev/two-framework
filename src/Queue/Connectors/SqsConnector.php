<?php

namespace Two\Queue\Connectors;

use Two\Queue\Connectors\ConnectorInterface;
use Two\Queue\Queues\SqsQueue;
use Aws\Sqs\SqsClient;


class SqsConnector implements ConnectorInterface
{

    /**
     * Establish a queue connection.
     *
     * @param  array  $config
     * @return \Two\Queue\Contracts\QueueInterface
     */
    public function connect(array $config)
    {
        $sqs = SqsClient::factory($config);

        return new SqsQueue($sqs, $config['queue']);
    }

}
