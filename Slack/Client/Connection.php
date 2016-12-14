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
     * @var bool
     */
    private $verifySsl = true;

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
     * @param bool $verifySsl
     *
     * @return $this
     */
    public function setVerifySsl($verifySsl)
    {
        $this->verifySsl = (bool) $verifySsl;

        return $this;
    }

    /**
     * @return bool
     */
    public function getVerifySsl()
    {
        return $this->verifySsl;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return (!empty($this->endpoint) && !empty($this->token));
    }
}
