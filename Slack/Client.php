<?php

namespace DZunke\SlackBundle\Slack;

use DZunke\SlackBundle\Slack\Client\Actions;
use DZunke\SlackBundle\Slack\Client\Connection;
use DZunke\SlackBundle\Slack\Client\Identity;
use DZunke\SlackBundle\Slack\Client\Response;
use Guzzle\Http\Client as GuzzleClient;
use Guzzle\Http\Url;

class Client
{

    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var Identity[]
     */
    protected $identities;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param Identity $identity
     */
    public function addIdentity(Identity $identity)
    {
        $this->identities[$identity->getUsername()] = $identity;
    }

    /**
     * @param string $username
     * @return Identity
     * @throws \Exception
     */
    public function getIdentity($username)
    {
        if (!isset($this->identities[$username])) {
            throw new \Exception('Identity "' . $username . '" does not exists');
        }

        return $this->identities[$username];
    }

    /**
     * @param string $action
     * @param array  $parameter
     * @param null   $identity
     * @return \Guzzle\Http\Message\Response
     */
    public function send($action, array $parameter, $identity = null)
    {
        if (!is_null($identity) && is_string($identity)) {
            $identity = $this->getIdentity($identity);
        }

        $action = Actions::loadClass($action);
        $action->setIdentity($identity);
        $action->setParameter($parameter);

        $url = new Url('https', $this->connection->getEndpoint());
        $url->setPath($action->getAction());
        $url->setQuery(
            array_merge(
                ['token' => $this->connection->getToken()],
                $action->getRenderedRequestParams()
            )
        );

        $guzzle   = new GuzzleClient();
        $response = $guzzle->createRequest('GET', $url)->send();

        return Response::parseGuzzleResponse($response);
    }
}
