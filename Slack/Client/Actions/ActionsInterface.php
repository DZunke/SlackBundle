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
     * @param Identity $config
     * @return $this
     */
    public function setIdentity(Identity $config);

    /**
     * @return bool
     * @throws \Exception
     */
    public function validate();

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
