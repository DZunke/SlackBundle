<?php

namespace DZunke\SlackBundle\Slack;

use DZunke\SlackBundle\Slack\Client\Actions;

class Messaging
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @param Client $client
     */
    public function  __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param string $channel
     * @param string $message
     * @param string $identity
     * @return Client\Response
     */
    public function message($channel, $message, $identity)
    {
        return $this->client->send(
            Actions::ACTION_POST_MESSAGE,
            [
                'channel' => $channel,
                'text'    => $message
            ],
            $identity
        );
    }
}
