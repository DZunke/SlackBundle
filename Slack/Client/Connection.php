<?php

namespace DZunke\SlackBundle\Slack\Client;

class Connection
{
    /**
     * @var string
     */
    protected $endpoint;

    /**
     * @var string
     */
    protected $token;

    /**
     * @param string $endpoint
     * @return $this
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = (string)$endpoint;

        return $this;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @param string $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = (string)$token;

        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

}
