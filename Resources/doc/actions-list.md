# Available Actions for Basic Usage

## api.test

[Slack Documentation](https://api.slack.com/methods/api.test)

Constant: \DZunke\SlackBundle\Slack\Client::ACTION_API_TEST

Available Parameters:

``` php
protected $parameter = [];
```

## auth.test

[Slack Documentation](https://api.slack.com/methods/auth.test)

Constant: \DZunke\SlackBundle\Slack\Client::ACTION_AUTH_TEST

Available Parameters:

``` php
protected $parameter = [];
```

## channels.info

[Slack Documentation](https://api.slack.com/methods/channels.info)

Constant: \DZunke\SlackBundle\Slack\Client::ACTION_CHANNELS_INFO

Available Parameters:

``` php
protected $parameter = [
   'channel' => null
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

## channels.setTopic

[Slack Documentation](https://api.slack.com/methods/channels.setTopic)

Constant: \DZunke\SlackBundle\Slack\Client::ACTION_CHANNELS_SET_TOPIC

Available Parameters:

``` php
protected $parameter = [
   'channel' => null,
   'topic'   => null
];
```

## chat.postMessage

[Slack Documentation](https://api.slack.com/methods/chat.postMessage)

Constant: \DZunke\SlackBundle\Slack\Client::ACTION_POST_MESSAGE

Available Parameters:

``` php
protected $parameter = [
    'identity'     => null,     # Object of Class \DZunke\SlackBundle\Slack\Messaging\Identity
    'channel'      => null,
    'text'         => null,
    'icon_url'     => null,
    'icon_emoji'   => null,
    'parse'        => 'full',
    'link_names'   => 1,
    'unfurl_links' => 1,
    'attachments'  => []
];
```
