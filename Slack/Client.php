<?php

namespace DZunke\SlackBundle\Slack;

use DZunke\SlackBundle\Slack\Client\Actions;
use DZunke\SlackBundle\Slack\Client\Connection;
use DZunke\SlackBundle\Slack\Client\IdentityBag;
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
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param string $action
     * @param array  $parameter
     * @return Response
     */
    public function send($action, array $parameter)
    {
        $action = Actions::loadClass($action);
        $action->setParameter($parameter);

        $url = $this->buildRequestUrl(
            $action,
            array_merge(
                ['token' => $this->connection->getToken()],
                $action->getRenderedRequestParams()
            )
        );

        $tries = 1;
        do {
            $response = $this->executeRequest($url);
            $response = Response::parseGuzzleResponse($response, $action);

            if (
                $response->getStatus() === true ||
                ($response->getStatus() == false && $response->getError() != Response::ERROR_RATE_LIMITED)
            ) {
                break;
            }

            ++$tries;

        } while ($tries <= $this->connection->getLimitRetries());


        return $response;
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
