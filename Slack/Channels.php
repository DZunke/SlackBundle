<?php

namespace DZunke\SlackBundle\Slack;

use DZunke\SlackBundle\Slack\Client\Actions;

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
        $channels = (array)$this->listAll()->getData();

        if (strpos($channelName, '#') !== false) {
            $channelName = str_replace('#', '', $channelName);
        }

        foreach ($channels as $name => $data) {
            if ($name == $channelName) {
                return $data['id'];
            }
        }

        return '';
    }

    /**
     * @return Client\Response
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
     * @return Client\Response
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
     * @return $this|Client\Response
     */
    public function setTopic($channel, $topic)
    {
        $channelInfo = $this->info($channel)->getData();

        $response = $this->client->send(
            Actions::ACTION_CHANNELS_SET_TOPIC,
            [
                'channel' => (string)$channel,
                'topic'   => (string)$topic
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

}
