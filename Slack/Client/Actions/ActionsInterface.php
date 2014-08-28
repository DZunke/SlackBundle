<?php

namespace DZunke\SlackBundle\Slack\Client\Actions;

interface ActionsInterface
{

    /**
     * @return array
     */
    public function getRenderedRequestParams();

    /**
     * @param array $response
     * @return array
     */
    public function parseResponse(array $response);

    /**
     * @return string
     */
    public function getAction();

    /**
     * @param array $parameter
     * @return $this
     */
    public function setParameter(array $parameter);

}
