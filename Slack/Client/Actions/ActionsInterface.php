<?php

namespace DZunke\SlackBundle\Slack\Client\Actions;

use DZunke\SlackBundle\Slack\Client\Identity;

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
     * @param Identity $config
     * @return $this
     */
    public function setIdentity(Identity $config);

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
