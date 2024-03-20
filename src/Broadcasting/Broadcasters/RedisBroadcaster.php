<?php

namespace Two\Broadcasting\Broadcasters;

use Two\Broadcasting\Broadcaster;

use Two\Container\Container;

use Two\Http\Request;

use Two\Redis\Database as RedisDatabase;


class RedisBroadcaster implements Broadcaster
{
    /**
     * The Redis instance.
     *
     * @var \Two\Contracts\Redis\Database
     */
    protected $redis;

    /**
     * The Redis connection to use for broadcasting.
     *
     * @var string
     */
    protected $connection;


    /**
     * Create a new broadcaster instance.
     *
     * @param  \Two\Contracts\Redis\Database  $redis
     * @param  string  $connection
     * @return void
     */
    public function __construct(Container $container, RedisDatabase $redis, $connection = null)
    {
        parent::__construct($container);

        //
        $this->redis = $redis;

        $this->connection = $connection;
    }

    /**
     * Return the valid authentication response.
     *
     * @param  \Two\Http\Request  $request
     * @param  mixed  $result
     * @return mixed
     */
    public function validAuthenticationResponse(Request $request, $result)
    {
        if (is_bool($result)) {
            return json_encode($result);
        }

        $user = $request->user();

        return json_encode(array(
            'payload' => array(
                'userId'   => $user->getAuthIdentifier(),
                'userInfo' => $result,
            ),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function broadcast(array $channels, $event, array $payload = array())
    {
        $connection = $this->redis->connection($this->connection);

        $payload = json_encode(array(
            'event' => $event,
            'data'  => $payload
        ));

        foreach ($this->formatChannels($channels) as $channel) {
            $connection->publish($channel, $payload);
        }
    }
 }
