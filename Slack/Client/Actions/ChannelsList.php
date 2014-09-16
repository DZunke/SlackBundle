<?php

namespace DZunke\SlackBundle\Slack\Client\Actions;

use DZunke\SlackBundle\Slack\Client\Actions;

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
        $channels = [];
        foreach ($response['channels'] as $channel) {
            $channels[$channel['name']] = [
                'id'     => $channel['id'],
                'active' => $channel['is_archived'],
                'topic'  => $channel['topic']['value'],
            ];
        }

        return $channels;
    }
}
