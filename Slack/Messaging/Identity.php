<?php

namespace DZunke\SlackBundle\Slack\Messaging;

class Identity
{
    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $iconUrl;

    /**
     * Available Emoji can be seen at http://www.emoji-cheat-sheet.com/
     *
     * @var string
     */
    protected $iconEmoji;

    /**
     * @param string $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = (string)$username;

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
     * @param string $iconUrl
     * @return $this
     */
    public function setIconUrl($iconUrl)
    {
        $this->iconUrl = (string)$iconUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getIconUrl()
    {
        return $this->iconUrl;
    }

    /**
     * @param string $iconEmoji
     * @return mixed
     */
    public function setIconEmoji($iconEmoji)
    {
        $this->iconEmoji = $iconEmoji;

        return $this->iconEmoji;
    }

    /**
     * @return string
     */
    public function getIconEmoji()
    {
        return $this->iconEmoji;
    }

}
