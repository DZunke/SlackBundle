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
     * @var int
     */
    protected $limitRetries = 3;

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

    /**
     * @param int $retries
     * @return $this
     */
    public function setLimitRetries($retries)
    {
        $this->limitRetries = (int)$retries;

        return $this;
    }

    /**
     * @return int
     */
    public function getLimitRetries()
    {
        return $this->limitRetries;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return (!empty($this->endpoint) && !empty($this->token));
    }
}
