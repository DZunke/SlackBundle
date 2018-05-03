<?php

namespace DZunke\SlackBundle\Slack;

use DZunke\SlackBundle\Slack\Client\Actions;
use DZunke\SlackBundle\Slack\Entity\MessageAttachment as Attachment;
use DZunke\SlackBundle\Slack\Messaging\IdentityBag;

class Messaging
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var IdentityBag
     */
    protected $identityBag;

    /**
     * @param Client      $client
     * @param IdentityBag $identityBag
     */
    public function __construct(Client $client, IdentityBag $identityBag)
    {
        $this->client      = $client;
        $this->identityBag = $identityBag;
    }

    /**
     * @return IdentityBag
     */
    public function getIdentityBag()
    {
        return $this->identityBag;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param string       $channel
     * @param string       $message
     * @param string       $identity
     * @param Attachment[] $attachments
     * @param array        $clientOptions
     *
     * @return Client\Response|bool
     *
     * @throws \InvalidArgumentException
     */
    public function message($channel, $message, $identity, array $attachments = [], array $clientOptions = [])
    {
        if (!$this->identityBag->has($identity)) {
            throw new \InvalidArgumentException(sprintf('identity "%s" is not registered', $identity));
        }

        return $this->client->send(
            Actions::ACTION_POST_MESSAGE,
            array_merge([
                'identity'    => $this->identityBag->get($identity),
                'channel'     => $channel,
                'text'        => $message,
                'attachments' => $attachments,
            ], $clientOptions)
        );
    }


    /**
     * @param string|array $channel # String is DEPRECATED scince v1.3 - Deliver Array
     * @param string       $title
     * @param string       $file
     * @param string|null  $comment
     *
     * @return Client\Response|false
     */
    public function upload($channel, $title, $file, $comment = null)
    {
        if (!file_exists($file)) {
            return false;
        }

        if (!is_array($channel)) {
            @trigger_error('Channel as String is deprecated scince v1.3, please deliver an Array of Channels', E_USER_DEPRECATED);
            $channel = [$channel];
        }

        $params = [];
        $params['title'] = $title;
        $params['initial_comment'] = $comment;
        $params['channels'] = implode(',', $channel);
        $params['content'] = file_get_contents($file);
        $params['fileType'] = mime_content_type($file);
        $params['filename'] = basename($file);

        return $this->client->send(
            Actions::ACTION_FILES_UPLOAD,
            $params
        );
    }
}
