<?php

namespace DZunke\SlackBundle\Slack\Client\Actions;

use DZunke\SlackBundle\Slack\Client\Actions;
use DZunke\SlackBundle\Slack\Client\Identity;

class ChannelsInfo implements ActionsInterface
{

    /**
     * @var array
     */
    protected $parameter = [
        'channel' => null
    ];

    /**
     * @return array
     */
    public function getRenderedRequestParams()
    {
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
        return Actions::ACTION_CHANNELS_INFO;
    }

    /**
     * @param array $response
     * @return array
     */
    public function parseResponse(array $response)
    {
        return [
            'id'     => $response['channel']['id'],
            'name'   => $response['channel']['name'],
            'active' => $response['channel']['is_archived'],
            'topic'  => $response['channel']['topic']['value'],
        ];
    }
}
