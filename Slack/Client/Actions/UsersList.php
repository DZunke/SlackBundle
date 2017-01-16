<?php

namespace DZunke\SlackBundle\Slack\Client\Actions;

use DZunke\SlackBundle\Slack\Client\Actions;

/**
 * @see https://api.slack.com/methods/users.list
 */
class UsersList implements ActionsInterface
{

    /**
     * @var array
     */
    protected $parameter = [
        'presence' => 1
    ];

    /**
     * @return array
     */
    public function getRenderedRequestParams()
    {
        return $this->parameter;
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
        return Actions::ACTION_USERS_LIST;
    }

    /**
     * @param array $response
     * @return array
     */
    public function parseResponse(array $response)
    {
        $users = [];
        foreach ($response['members'] as $user) {
            $users[$user['name']] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'deleted' => (bool)$user['deleted'],
                'real_name' => $user['profile']['real_name'],
                'email' => isset($user['profile']['email']) ? $user['profile']['email'] : null,
                'is_bot' => (bool)$user['is_bot'],
                'presence' => isset($user['presence']) ? $user['presence'] : null
            ];
        }

        return $users;
    }
}
