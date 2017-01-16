<?php

namespace DZunke\SlackBundle\Slack;

use DZunke\SlackBundle\Slack\Client\Actions;
use DZunke\SlackBundle\Slack\Entity\Message;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Channels
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
     * @param string $channelName
     * @return string
     */
    public function getId($channelName)
    {
        if ($channelName[0] === 'C') {
            return $channelName;
        }

        if (strpos($channelName, '#') !== false) {
            $channelName = str_replace('#', '', $channelName);
        }

        foreach ((array)$this->listAll()->getData() as $name => $data) {
            if ($name == $channelName) {
                return $data['id'];
            }
        }

        return '';
    }

    /**
     * @return Client\Response|bool
     */
    public function listAll()
    {
        return $this->client->send(
            Actions::ACTION_CHANNELS_LIST,
            []
        );
    }

    /**
     * @param string $channel The Id of the Channel - NOT the Name. self::getId() if needed
     * @return Client\Response|bool
     */
    public function info($channel)
    {
        return $this->client->send(
            Actions::ACTION_CHANNELS_INFO,
            [
                'channel' => (string)$channel
            ]
        );
    }

    /**
     * @param string $channel The Id of the Channel - NOT the Name. self::getId() if needed
     * @param string $topic
     * @return $this|Client\Response|bool
     */
    public function setTopic($channel, $topic)
    {
        $channelInfo = $this->info($channel)->getData();

        $response = $this->client->send(
            Actions::ACTION_CHANNELS_SET_TOPIC,
            [
                'channel' => (string)$channel,
                'topic' => (string)$topic
            ]
        );

        if (!$response->getStatus()) {
            return $response;
        }

        $data              = $response->getData();
        $data['old_topic'] = $channelInfo['topic'];
        $data['new_topic'] = (string)$topic;

        return $response->setData($data);
    }

    /**
     * @param string $channel
     * @param int    $from
     * @param int    $count
     * @return Message[]
     */
    public function history($channel, $from = null, $count = 10)
    {
        $messages = $this->client->send(
            Client\Actions::ACTION_CHANNELS_HISTORY,
            [
                'channel' => $this->getId($channel),
                'oldest' => is_null($from) ? time() : $from,
                'count' => $count
            ]
        );

        $repository = [];
        if (!empty($messages->getData()['messages'])) {
            $messages = $messages->getData()['messages'];
            foreach (array_reverse($messages) as $message) {
                $objMsg = new Message();
                $objMsg->setId($message['ts']);
                $objMsg->setChannel($channel);
                $objMsg->setType(isset($message['subtype']) ? $message['subtype'] : $message['type']);
                $objMsg->setUserId(isset($message['user']) ? $message['user'] : null);
                $objMsg->setUsername(isset($message['username']) ? $message['username'] : null);
                $objMsg->setContent($message['text']);

                $repository[] = $objMsg;
            }
        }

        return $repository;
    }

}
