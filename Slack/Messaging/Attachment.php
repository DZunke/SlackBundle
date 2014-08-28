<?php

namespace DZunke\SlackBundle\Slack\Messaging;

class Attachment
{
    /**
     * Can either be one of 'good', 'warning', 'danger', or any hex color code
     *
     * @var string
     */
    protected $color;

    /**
     * Required text summary of the attachment that is shown by clients that understand attachments
     * but choose not to show them. By Default this will be the same as the Text.
     *
     * @var string
     */
    protected $fallback;

    /**
     * Optional text that should appear within the attachment
     *
     * @var string
     */
    protected $text;

    /**
     * Optional text that should appear above the formatted data
     *
     * @var string
     */
    protected $pretext;

    /**
     * A Bunch of Fields that should be displayed as Attachement. They consist of the Fields:
     *
     * "title": The Header for this Field
     * "value": The Textg for this Field, can be multiline
     * "short": boolean to indicate if the field is short enough to be displayed side-by-side
     *
     * @var array
     */
    protected $fields = [];

    /**
     * @param string $color
     * @return $this
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $fallback
     * @return $this
     */
    public function setFallback($fallback)
    {
        $this->fallback = $fallback;

        return $this;
    }

    /**
     * @return string
     */
    public function getFallback()
    {
        return $this->fallback;
    }

    /**
     * @param array $fields
     * @return $this
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * @param string $title
     * @param string $text
     * @param bool   $scale
     *
     * @return $this
     */
    public function addField($title, $text, $scale = false)
    {
        $this->fields[] = [
            'title' => (string)$title,
            'value' => (string)$text,
            'short' => $scale
        ];
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param string $pretext
     * @return $this
     */
    public function setPretext($pretext)
    {
        $this->pretext = $pretext;

        return $this;
    }

    /**
     * @return string
     */
    public function getPretext()
    {
        return $this->pretext;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'fallback' => $this->getFallback(),
            'pretext'  => $this->getPretext(),
            'color'    => $this->getColor(),
            'fields'   => $this->getFields()
        ];
    }
}
