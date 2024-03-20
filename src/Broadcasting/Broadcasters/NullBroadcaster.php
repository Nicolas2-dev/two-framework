<?php

namespace Two\Broadcasting\Broadcasters;

use Two\Broadcasting\Broadcaster;

use Two\Http\Request;


class NullBroadcaster extends Broadcaster
{

    /**
     * {@inheritdoc}
     */
    public function authenticate(Request $request)
    {
        //
    }

    /**
     * {@inheritdoc}
     */
    public function validAuthenticationResponse(Request $request, $result)
    {
        //
    }

    /**
     * {@inheritdoc}
     */
    public function broadcast(array $channels, $event, array $payload = array())
    {
        //
    }
}
