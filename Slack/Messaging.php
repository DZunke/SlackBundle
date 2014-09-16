<?php

namespace DZunke\SlackBundle\Slack;

use DZunke\SlackBundle\Slack\Client\Actions;
use DZunke\SlackBundle\Slack\Messaging\Attachment;
use DZunke\SlackBundle\Slack\Messaging\IdentityBag;

class Messaging
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var IdentityBag
     */
    protected $identityBag;

    /**
     * @param Client      $client
     * @param IdentityBag $identityBag
     */
    public function  __construct(Client $client, IdentityBag $identityBag)
    {
        $this->client      = $client;
        $this->identityBag = $identityBag;
    }

    /**
     * @return IdentityBag
     */
    public function getIdentityBag()
    {
        return $this->identityBag;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param string       $channel
     * @param string       $message
     * @param string       $identity
     * @param Attachment[] $attachments
     * @return Client\Response|bool
     * @throws \InvalidArgumentException
     */
    public function message($channel, $message, $identity, array $attachments = [])
    {
        if (!$this->identityBag->has($identity)) {
            throw new \InvalidArgumentException('identiy "' . $identity . '" is not registered');
        }

        return $this->client->send(
            Actions::ACTION_POST_MESSAGE,
            [
                'identity'    => $this->identityBag->get($identity),
                'channel'     => $channel,
                'text'        => $message,
                'attachments' => $attachments
            ],
            $identity
        );
    }
}
