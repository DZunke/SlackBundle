<?php

namespace DZunke\SlackBundle\Slack\Client\Actions;

use DZunke\SlackBundle\Slack\Client\Actions;
use DZunke\SlackBundle\Slack\Client\Identity;

class ChannelsList implements ActionsInterface
{

    /**
     * @var array
     */
    protected $parameter = [
        'exclude_archived' => 1
    ];

    /**
     * @return array
     */
    public function getRenderedRequestParams()
    {
        return $this->parameter;
    }

    /**
     * @param Identity $identity
     * @return $this
     */
    public function setIdentity(Identity $identity)
    {
        return $this;
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
        return Actions::ACTION_CHANNELS_LIST;
    }

    /**
     * @param array $response
     * @return array
     */
    public function parseResponse(array $response)
    {
        return $response['channels'];
    }
}
