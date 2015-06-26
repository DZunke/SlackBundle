<?php

namespace DZunke\SlackBundle;

/**
 * there are some events that will be triggerd in Bot-Mode to
 * react on specific actions in the watched channel
 */
class Event
{

    /**
     * event for standard messages
     */
    const MESSAGE = 'slack.message';

    /**
     * event for messages that contain a joined user
     */
    const JOIN = 'slack.channel.join';

    /**
     * event for messages that contain a leave
     */
    const LEAVE = 'slack.channel.leave';

}
