<?php

namespace DZunke\SlackBundle\Slack;

use DZunke\SlackBundle\Slack\Client\Actions;
use DZunke\SlackBundle\Slack\Client\Connection;
use DZunke\SlackBundle\Slack\Client\Response;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Uri;
use Symfony\Component\HttpFoundation\Request;

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
     * @param bool   $multipart Whether to use multipart/form-data or the default application/x-www-form-urlencoded
     *
     * @return Response|bool
     */
    public function send($action, array $parameter = [], $multipart = false)
    {
        if (!$this->connection->isValid()) {
            return false;
        }

        $action = Actions::loadClass($action);
        $action->setParameter($parameter);

        $parsedRequestParams = array_merge(
            ['token' => $this->connection->getToken()],
            $action->getRenderedRequestParams()
        );

        $url = $this->buildUri($action, $parsedRequestParams);

        $tries = 1;
        do {
            $response = $this->executeRequest(
                $url,
                $this->connection->getHttpMethod() === Request::METHOD_POST ? $parsedRequestParams : null,
                $multipart
            );
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
        $uri = $this->connection->getEndpoint() . '/' . $action->getAction();

        if ($this->connection->getHttpMethod() === Request::METHOD_GET) {
            $uri .= '?' . http_build_query($requestParams);
        }

        return new Uri($uri);
    }

    /**
     * @param Uri $uri
     * @param array $params    form post values
     * @param bool  $multipart Whether to use multipart/form-data or the default application/x-www-form-urlencoded
     *
     * @return \GuzzleHttp\Psr7\Response
     */
    protected function executeRequest(Uri $uri, array $params = null, $multipart = false)
    {
        $guzzle = new GuzzleClient(['verify' => $this->connection->getVerifySsl()]);

        if (null !== $params) {
            if ($multipart) {
                $multipartParams = [];
                foreach ($params as $paramName => $paramValue) {
                    $multipartParams[] = [
                        'name'     => $paramName,
                        'contents' => $paramValue,
                    ];
                }
                $postParams = ['multipart' => $multipartParams];
            } else {
                $postParams = ['form_params' => $params];
            }
        } else {
            $postParams = [];
        }

        return $guzzle->request(
            $this->connection->getHttpMethod(),
            $uri,
            $postParams
        );
    }
}
