<?php

namespace DZunke\SlackBundle\Slack\Client;

use DZunke\SlackBundle\Slack\Client\Actions\ActionsInterface;

class Actions
{
    /**
     * Describes the Action that must be called to send a message to a Channel
     */
    const ACTION_POST_MESSAGE = 'chat.postMessage';

    /**
     * @var array
     */
    protected static $classes = [
        self::ACTION_POST_MESSAGE => 'PostMessage'
    ];

    /**
     * @param string $action
     * @return ActionsInterface
     * @throws \Exception
     */
    public static function loadClass($action)
    {
        if (!array_key_exists($action, self::$classes)) {
            throw new \Exception('the called action "' . $action . '" does not exist');
        }

        $classname = '\\DZunke\\SlackBundle\\Slack\\Client\\Actions\\' . self::$classes[$action];

        return new $classname;
    }
}
