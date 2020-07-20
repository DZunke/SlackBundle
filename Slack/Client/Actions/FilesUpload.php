<?php

namespace DZunke\SlackBundle\Slack\Client\Actions;

use DZunke\SlackBundle\Slack\Client\Actions;

/**
 * @see https://api.slack.com/methods/files.upload
 */
class FilesUpload implements ActionsInterface
{

    /**
     * @var array
     */
    protected $parameter = [
        'file'            => null,
        'filetype'        => null,
        'filename'        => null,
        'title'           => null,
        'initial_comment' => null,
        'channels'        => null
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
        return Actions::ACTION_FILES_UPLOAD;
    }

    /**
     * @param array $response
     * @return array
     */
    public function parseResponse(array $response)
    {
        if (isset($response['ok']) && $response['ok'] === true) {
            return $response['file'];
        }

        return $response;
    }
}
