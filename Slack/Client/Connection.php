<?php

namespace DZunke\SlackBundle\Slack\Client;

use Symfony\Component\HttpFoundation\Request;

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
     * @var string
     */
    private $httpMethod = Request::METHOD_GET;

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @param string $endpoint
     *
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
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     *
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = (string)$token;

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
     * @param int $retries
     *
     * @return $this
     */
    public function setLimitRetries($retries)
    {
        $this->limitRetries = (int)$retries;

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
     * @param bool $verifySsl
     *
     * @return $this
     */
    public function setVerifySsl($verifySsl)
    {
        $this->verifySsl = (bool)$verifySsl;

        return $this;
    }

    /**
     * @return string
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    /**
     * @return $this
     */
    public function isHttpGetMethod()
    {
        $this->httpMethod = Request::METHOD_GET;

        return $this;
    }

    /**
     * @return $this
     */
    public function isHttpPostMethod()
    {
        $this->httpMethod = Request::METHOD_POST;

        return $this;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return (!empty($this->endpoint) && !empty($this->token));
    }
}
