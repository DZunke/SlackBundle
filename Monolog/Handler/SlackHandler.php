<?php

namespace DZunke\SlackBundle\Monolog\Handler;

use DZunke\SlackBundle\Slack\Entity\MessageAttachment;
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
        $attachment = new MessageAttachment();

        switch($record['level']) {
            case Logger::DEBUG:
            case Logger::INFO:
                $attachment->setColor('good');
                break;
            case Logger::NOTICE:
            case Logger::WARNING:
                $attachment->setColor('warning');
                break;
            case Logger::ERROR:
            case Logger::CRITICAL:
            case Logger::ALERT:
            case Logger::EMERGENCY:
                $attachment->setColor('danger');
                break;
        }

        $attachment->addField($record['level_name'], $record['formatted']);

        $this->messagingClient->message($this->channel, '', $this->username, [$attachment]);
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultFormatter()
    {
        return new LineFormatter();
    }
}

