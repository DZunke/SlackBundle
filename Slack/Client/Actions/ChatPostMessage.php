<?php

namespace DZunke\SlackBundle\Slack\Client\Actions;

use DZunke\SlackBundle\Slack\Client\Actions;
use DZunke\SlackBundle\Slack\Messaging\Attachment;
use DZunke\SlackBundle\Slack\Messaging\Identity;

class ChatPostMessage implements ActionsInterface
{
    /**
     * @var array
     */
    protected $parameter = [
        'identity'     => null,
        'channel'      => null,
        'text'         => null,
        'icon_url'     => null,
        'icon_emoji'   => null,
        'parse'        => 'full',
        'link_names'   => 1,
        'unfurl_links' => 1,
        'attachments'  => [],
    ];

    /**
     * @return array
     * @throws \Exception
     */
    public function getRenderedRequestParams()
    {
        if (is_null($this->parameter['identity']) || !$this->parameter['identity'] instanceof Identity) {
            throw new \Exception('no identity given');
        }

        $this->parseIdentity();
        $this->parseAttachments();

        return $this->parameter;
    }

    private function parseAttachments()
    {
        if (empty($this->parameter['attachments'])) {
            return;
        }

        $attachments = [];
        foreach ($this->parameter['attachments'] as $attachmentObj) {
            if (!$attachmentObj instanceof Attachment) {
                throw new \Exception('atachments must be instance of \DZunke\SlackBundle\Slack\Messaging\Attachment');
            }

            $attachments[] = $attachmentObj->toArray();
        }
        $this->parameter['attachments'] = json_encode($attachments);
    }

    private function parseIdentity()
    {
        $this->parameter['username']   = $this->parameter['identity']->getUsername();
        $this->parameter['icon_url']   = $this->parameter['identity']->getIconUrl();
        $this->parameter['icon_emoji'] = $this->parameter['identity']->getIconEmoji();
        unset($this->parameter['identity']);
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
