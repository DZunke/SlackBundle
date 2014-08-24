<?php

namespace DZunke\SlackBundle\Slack\Client\Actions;

use DZunke\SlackBundle\Slack\Client\Actions;
use DZunke\SlackBundle\Slack\Client\Identity;

class ChatPostMessage implements ActionsInterface
{
    /**
     * @var Identity
     */
    protected $identity;

    /**
     * @var array
     */
    protected $parameter = [
        'username'     => null,
        'channel'      => null,
        'text'         => null,
        'icon_url'     => null,
        'icon_emoji'   => null,
        'parse'        => 'full',
        'link_names'   => 1,
        'unfurl_links' => 1
    ];

    /**
     * @return array
     * @throws \Exception
     */
    public function getRenderedRequestParams()
    {
        if (is_null($this->identity)) {
            throw new \Exception('no identity given');
        }

        $this->parameter['username']   = $this->identity->getUsername();
        $this->parameter['icon_url']   = $this->identity->getIconUrl();
        $this->parameter['icon_emoji'] = $this->identity->getIconEmoji();

        return $this->parameter;
    }

    /**
     * @param Identity $identity
     * @return $this
     */
    public function setIdentity(Identity $identity)
    {
        $this->identity = $identity;

        return $this;
    }

    /**
     * @param array $parameter
     * @return $this
     */
    public function setParameter(array $parameter)
    {
        foreach ($parameter as $key => $value) {
            if (array_key_exists($key, $this->parameter)) {
                $this->parameter[$key] = $value;
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return Actions::ACTION_POST_MESSAGE;
    }

    /**
     * @param array $response
     * @return array
     */
    public function parseResponse(array $response)
    {
        return [
            'timestamp' => $response['ts']
        ];
    }
}
