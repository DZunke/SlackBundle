<?php

namespace DZunke\SlackBundle\Slack;

use DZunke\SlackBundle\Slack\Client\Actions;
use DZunke\SlackBundle\Slack\Client\Connection;
use DZunke\SlackBundle\Slack\Client\Identity;
use DZunke\SlackBundle\Slack\Client\Response;
use Guzzle\Common\Event;
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

        $url      = $this->buildRequestUrl(
            $action,
            array_merge(
                ['token' => $this->connection->getToken()],
                $action->getRenderedRequestParams()
            )
        );
        $response = $this->executeRequest($url);

        return Response::parseGuzzleResponse($response);
    }

    /**
     * @param Actions\ActionsInterface $action
     * @param array                    $requestParams
     * @return Url
     */
    protected function buildRequestUrl(Actions\ActionsInterface $action, array $requestParams)
    {
        $url = new Url('https', $this->connection->getEndpoint());
        $url->setPath($action->getAction());
        $url->setQuery($requestParams);

        return $url;
    }

    /**
     * @param Url $url
     * @return \Guzzle\Http\Message\Response
     */
    protected function executeRequest(Url $url)
    {
        $guzzle = new GuzzleClient();
        $guzzle->getEventDispatcher()->addListener(
            'request.error',
            function (Event $event) {
                if ($event['response']->getStatusCode() != 200) {
                    $event->stopPropagation();
                }
            }
        );

        return $guzzle->createRequest('GET', $url)->send();
    }
}
