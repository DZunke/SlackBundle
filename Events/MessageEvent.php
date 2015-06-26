<?php

namespace DZunke\SlackBundle\Events;

use DZunke\SlackBundle\Slack\Entity\Message;
use Symfony\Component\EventDispatcher\Event;

class MessageEvent extends Event
{

    /**
     * @var Message
     */
    private $message;

    /**
     * @param object $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * @return Message
     */
    public function getMessage()
    {
        return $this->message;
    }
}
