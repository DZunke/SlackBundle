<?php

namespace DZunke\SlackBundle\Slack\Client\Actions;

use DZunke\SlackBundle\Slack\Client\Actions;
use DZunke\SlackBundle\Slack\Client\Identity;

class AuthTest implements ActionsInterface
{

    /**
     * @var array
     */
    protected $parameter = [];

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
        return $this;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return Actions::ACTION_AUTH_TEST;
    }

    /**
     * @param array $response
     * @return array
     */
    public function parseResponse(array $response)
    {
        return [
            'user' => $response['user']
        ];
    }
}
