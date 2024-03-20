<?php

namespace Two\Queue\Connectors;

use IronMQ;

use Two\Http\Request;
use Two\Queue\Connectors\ConnectorInterface;
use Two\Queue\Queues\IronQueue;
use Two\Encryption\Encrypter;


class IronConnector implements ConnectorInterface
{

    /**
     * The encrypter instance.
     *
     * @var \Two\Encryption\Encrypter
     */
    protected $crypt;

    /**
     * The current request instance.
     *
     * @var \Two\Http\Request
     */
    protected $request;

    /**
     * Create a new Iron connector instance.
     *
     * @param  \Two\Encryption\Encrypter  $crypt
     * @param  \Two\Http\Request  $request
     * @return void
     */
    public function __construct(Encrypter $crypt, Request $request)
    {
        $this->crypt = $crypt;
        $this->request = $request;
    }

    /**
     * Establish a queue connection.
     *
     * @param  array  $config
     * @return \Two\Queue\Contracts\QueueInterface
     */
    public function connect(array $config)
    {
        $ironConfig = array('token' => $config['token'], 'project_id' => $config['project']);

        if (isset($config['host'])) $ironConfig['host'] = $config['host'];

        $iron = new IronMQ($ironConfig);

        if (isset($config['ssl_verifypeer']))
        {
            $iron->ssl_verifypeer = $config['ssl_verifypeer'];
        }

        return new IronQueue($iron, $this->request, $config['queue'], $config['encrypt']);
    }

}
