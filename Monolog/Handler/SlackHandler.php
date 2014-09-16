<?php

namespace DZunke\SlackBundle\Monolog\Handler;

use DZunke\SlackBundle\Slack\Messaging;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class SlackHandler extends AbstractProcessingHandler
{
    /**
     * @var Messaging
     */
    protected $messagingClient;

    /**
     * @var string
     */
    protected $channel;

    /**
     * @var string
     */
    protected $username;

    /**
     * @param Messaging $messaging
     * @param bool      $channel
     * @param string    $username
     * @param int       $level
     * @param bool      $bubble
     * @throws \InvalidArgumentException
     */
    public function __construct(Messaging $messaging, $channel, $username, $level = Logger::DEBUG, $bubble = true)
    {
        $this->messagingClient = $messaging;
        $this->channel         = $channel;
        $this->username        = $username;

        if (!$this->messagingClient->getIdentityBag()->has($username)) {
            throw new \InvalidArgumentException('Invalid Username given');
        }

        parent::__construct($level, $bubble);
    }

    protected function write(array $record)
    {
        $this->messagingClient->message($this->channel, $record["formatted"], $this->username);
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultFormatter()
    {
        return new LineFormatter();
    }
}

