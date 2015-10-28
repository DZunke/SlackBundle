<?php

namespace DZunke\SlackBundle\Slack\Client\Actions;

use DZunke\SlackBundle\Slack\Client\Actions;

/**
 * @see https://api.slack.com/methods/channels.invite
 */
class ChannelsInvite implements ActionsInterface
{

    /**
     * @var array
     */
    protected $parameter = [
        'channel' => null,
        'user' => null
    ];

    /**
     * @return array
     * @throws \Exception
     */
    public function getRenderedRequestParams()
    {
        if (is_null($this->parameter['channel']) || is_null($this->parameter['user'])) {
            throw new \Exception('both parameters channel and user must be given');
        }

        return $this->parameter;
    }

    /**
     * @param array $parameter
     * @return $this
     */
    public function setParameter(array $parameter)
    {
        foreach ($parameter as $key => $value) {
            if (array_key_exists($key, $this->parameter)) {
                $this->parameter[$key] = $value;
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return Actions::ACTION_CHANNELS_INVITE;
    }

    /**
     * @param array $response
     * @return array
     */
    public function parseResponse(array $response)
    {
        return [];
    }
}
