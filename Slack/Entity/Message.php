<?php

namespace DZunke\SlackBundle\Slack\Entity;

use DZunke\SlackBundle\Slack\Entity\MessageAttachment as Attachment;

class Message
{

    const TYPE_MESSAGE = 'message';
    const TYPE_CHANNEL_JOIN = 'channel_join';
    const TYPE_CHANNEL_LEAVE = 'channel_leave';

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $channel;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $content;

    /**
     * @var Attachment[]
     */
    private $attachments;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @param string $channel
     * @return $this
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     * @return $this
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return bool
     */
    public function isBot()
    {
        return !empty($this->id) && empty($this->userId) && !empty($this->username);
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return MessageAttachment[]
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * @param MessageAttachment $attachment
     * @return $this
     */
    public function addAttachment(MessageAttachment $attachment)
    {
        $this->attachments[] = $attachment;

        return $this;
    }

    /**
     * @param MessageAttachment[] $attachments
     * @return $this
     */
    public function setAttachments($attachments)
    {
        $this->attachments = $attachments;

        return $this;
    }

}
