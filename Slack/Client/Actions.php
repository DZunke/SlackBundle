<?php

namespace DZunke\SlackBundle\Slack\Client;

use DZunke\SlackBundle\Slack\Client\Actions\ActionsInterface;

class Actions
{
    const ACTION_POST_MESSAGE = 'chat.postMessage';
    const ACTION_CHANNELS_LIST = 'channels.list';
    const ACTION_API_TEST = 'api.test';
    const ACTION_AUTH_TEST = 'auth.test';
    const ACTION_CHANNELS_SET_TOPIC = 'channels.setTopic';
    const ACTION_CHANNELS_INFO = 'channels.info';
    const ACTION_CHANNELS_INVITE = 'channels.invite';
    const ACTION_CHANNELS_HISTORY = 'channels.history';
    const ACTION_FILES_UPLOAD = 'files.upload';
    const ACTION_USERS_LIST = 'users.list';

    /**
     * @var array
     */
    protected static $classes = [
        self::ACTION_POST_MESSAGE => 'ChatPostMessage',
        self::ACTION_CHANNELS_LIST => 'ChannelsList',
        self::ACTION_API_TEST => 'ApiTest',
        self::ACTION_AUTH_TEST => 'AuthTest',
        self::ACTION_CHANNELS_SET_TOPIC => 'ChannelsSetTopic',
        self::ACTION_CHANNELS_INFO => 'ChannelsInfo',
        self::ACTION_CHANNELS_INVITE => 'ChannelsInvite',
        self::ACTION_CHANNELS_HISTORY => 'ChannelsHistory',
        self::ACTION_FILES_UPLOAD => 'FilesUpload',
        self::ACTION_USERS_LIST => 'UsersList'
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
