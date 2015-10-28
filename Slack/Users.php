<?php

namespace DZunke\SlackBundle\Slack;

use DZunke\SlackBundle\Slack\Client\Actions;

class Users
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @param Client $client
     */
    public function  __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return array
     */
    public function getUsers()
    {
        return $this->client->send(Actions::ACTION_USERS_LIST)->getData();
    }

    /**
     * @return array
     */
    public function getActiveUsers()
    {
        return array_filter(
            $this->getUsers(),
            function ($user) {
                return $user['deleted'] === false;
            }
        );
    }

    /**
     * @return array
     */
    public function getDeletedUsers()
    {
        return array_filter(
            $this->getUsers(),
            function ($user) {
                return $user['deleted'] === true;
            }
        );
    }

    /**
     * @param string $name
     * @return null|array
     */
    public function getId($name)
    {
        $users = $this->getUsers();

        return array_key_exists($name, $users) ? $users[$name]['id'] : null;
    }
}
