<?php

namespace DZunke\SlackBundle\Slack\Entity;

class MessageAttachment
{
    /**
     * Optional link to author icon
     *
     * @var string URL address
     */
    protected $authorIcon;

    /**
     * Optional link to author
     *
     * @var string URL address
     */
    protected $authorLink;

    /**
     * Optional name of author
     *
     * @var string
     */
    protected $authorName;

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
     * Optional link to image
     *
     * @var string URL address
     */
    protected $imageUrl;

    /**
     * Optional text that should appear within the attachment
     *
     * @var string
     */
    protected $text;

    /**
     * Optional title
     *
     * @var string
     */
    protected $title;

    /**
     * Optional title link
     *
     * @var string
     */
    protected $titleLink;

    /**
     * Optional link to thumbnail
     *
     * @var string
     */
    protected $thumbUrl;

    /**
     * Optional text that should appear above the formatted data
     *
     * @var string
     */
    protected $pretext;

    /**
     * Optional footer text
     *
     * @var string
     */
    protected $footer;

    /**
     * Optional footer icon
     *
     * @var string
     */
    protected $footerIcon;

    /**
     * Optional timestamp
     *
     * @var int
     */
    protected $ts;

    /**
     * A Bunch of fields that should be displayed as Attachment. They consist of the fields:
     *
     * "title": The Header for this Field
     * "value": The Text for this Field, can be multiline
     * "short": boolean to indicate if the field is short enough to be displayed side-by-side
     *
     * @var array
     */
    protected $fields = [];

    /**
     * A Bunch of fields that should be displayed as button Attachment. They consist of the fields:
     *
     * "text": A UTF-8 string label for this button. Be brief but descriptive and actionable.
     * "url": The fully qualified http or https URL to deliver users to. Invalid URLs will result in a message posted with the button omitted.
     * "style": Optional - Setting to primary turns the button green and indicates the best forward action to take.
     *          Providing danger turns the button red and indicates it some kind of destructive action.
     *          Use sparingly. By default, buttons will use the UI's default text color.
     *
     * @var array
     */
    protected $actions = [];

    /**
     * @return string
     */
    public function getAuthorIcon()
    {
        return $this->authorIcon;
    }

    /**
     * @param string $authorIcon
     *
     * @return $this
     */
    public function setAuthorIcon($authorIcon)
    {
        $this->authorIcon = $authorIcon;

        return $this;
    }

    /**
     * @return string
     */
    public function getAuthorLink()
    {
        return $this->authorLink;
    }

    /**
     * @param string $authorLink
     *
     * @return $this
     */
    public function setAuthorLink($authorLink)
    {
        $this->authorLink = $authorLink;

        return $this;
    }

    /**
     * @return string
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * @param string $authorName
     *
     * @return $this
     */
    public function setAuthorName($authorName)
    {
        $this->authorName = $authorName;

        return $this;
    }

    /**
     * @param string $color
     *
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
     *
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
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @param string $imageUrl
     *
     * @return $this
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * @param array $fields
     *
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
            'title' => (string) $title,
            'value' => (string) $text,
            'short' => $scale,
        ];

        return $this;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param array $actions
     *
     * @return $this
     */
    public function setActions(array $actions)
    {
        $this->actions = $actions;

        return $this;
    }

    /**
     * @param string $text
     * @param string $url
     * @param string $style
     *
     * @return $this
     */
    public function addAction($text, $url, $style = null)
    {
        $this->actions[] = [
            'type' => 'button',
            'text' => (string) $text,
            'url' => (string) $url,
            'style' => (string) $style,
        ];

        return $this;
    }

    /**
     * @return array
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * @param string $pretext
     *
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
     *
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
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitleLink()
    {
        return $this->titleLink;
    }

    /**
     * @param string $titleLink
     *
     * @return $this
     */
    public function setTitleLink($titleLink)
    {
        $this->titleLink = $titleLink;

        return $this;
    }

    /**
     * @return string
     */
    public function getThumbUrl()
    {
        return $this->thumbUrl;
    }

    /**
     * @param string $thumbUrl
     *
     * @return $this
     */
    public function setThumbUrl($thumbUrl)
    {
        $this->thumbUrl = $thumbUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getFooter()
    {
        return $this->footer;
    }

    /**
     * @param string $footer
     */
    public function setFooter($footer)
    {
        $this->footer = $footer;
    }

    /**
     * @return string
     */
    public function getFooterIcon()
    {
        return $this->footerIcon;
    }

    /**
     * @param string $footerIcon
     */
    public function setFooterIcon($footerIcon)
    {
        $this->footerIcon = $footerIcon;
    }

    /**
     * @return int
     */
    public function getTs()
    {
        return $this->ts;
    }

    /**
     * @param int $ts
     */
    public function setTs($ts)
    {
        $this->ts = $ts;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'fallback' => $this->getFallback(),
            'color' => $this->getColor(),
            'pretext' => $this->getPretext(),
            'author_name' => $this->getAuthorName(),
            'author_link' => $this->getAuthorLink(),
            'author_icon' => $this->getAuthorIcon(),
            'title' => $this->getTitle(),
            'title_link' => $this->getTitleLink(),
            'text' => $this->getText(),
            'fields'  => $this->getFields(),
            'image_url' => $this->getImageUrl(),
            'thumb_url' => $this->getThumbUrl(),
            'footer' => $this->getFooter(),
            'footer_icon' => $this->getFooterIcon(),
            'ts' => $this->getTs(),
            'actions'  => $this->getActions(),
        ];
    }
}
