# Available Actions for Basic Usage

## chat.postMessage

[Slack Documentation](https://api.slack.com/methods/chat.postMessage)

Constant: \DZunke\SlackBundle\Slack\Client::ACTION_POST_MESSAGE

Available Parameters:

``` php
protected $parameter = [
    'channel'      => null,
    'text'         => null,
    'parse'        => 'full',
    'link_names'   => 1,
    'unfurl_links' => 1
];
```

## channels.list

[Slack Documentation](https://api.slack.com/methods/channels.list)

Constant: \DZunke\SlackBundle\Slack\Client::ACTION_CHANNELS_LIST

Available Parameters:

``` php
protected $parameter = [
    'exclude_archived' => 1
];
```

## api.test

[Slack Documentation](https://api.slack.com/methods/api.test)

Constant: \DZunke\SlackBundle\Slack\Client::ACTION_API_TEST

Available Parameters:

``` php
protected $parameter = [];
```
