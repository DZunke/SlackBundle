<?php

namespace DZunke\SlackBundle\Slack;

use DZunke\SlackBundle\Slack\Client\Actions;
use DZunke\SlackBundle\Slack\Client\Connection;
use DZunke\SlackBundle\Slack\Client\Response;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Uri;

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
     * @param array $parameter
     *
     * @return Response|bool
     */
    public function send($action, array $parameter = [])
    {
        if (!$this->connection->isValid()) {
            return false;
        }

        $action = Actions::loadClass($action);
        $action->setParameter($parameter);

        $url = $this->buildUri(
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
                ($response->getStatus() === false && $response->getError() != Response::ERROR_RATE_LIMITED)
            ) {
                break;
            }

            ++$tries;

        } while ($tries <= $this->connection->getLimitRetries());


        return $response;
    }

    /**
     * @param Actions\ActionsInterface $action
     * @param array $requestParams
     *
     * @return Uri
     */
    protected function buildUri(Actions\ActionsInterface $action, array $requestParams)
    {
        $uri = new Uri(
            $this->connection->getEndpoint()
            . '/'
            . $action->getAction()
            . '?' . http_build_query($requestParams)
        );

        return $uri;
    }

    /**
     * @param Uri $uri
     *
     * @return \GuzzleHttp\Psr7\Response
     */
    protected function executeRequest(Uri $uri)
    {
        $guzzle = new GuzzleClient(['verify' => $this->connection->getVerifySsl()]);

        return $guzzle->request('GET', $uri);
    }
}
