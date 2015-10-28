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

## channels.invite

[Slack Documentation](https://api.slack.com/methods/channels.invite)

Constant: \DZunke\SlackBundle\Slack\Client::ACTION_CHANNELS_INVITE

Available Parameters:

Both Parameters have to be the if of the entity and not the raw name

``` php
protected $parameter = [
   'channel' => null,
   'user' => null,
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

## files.upload

[Slack Documentation](https://api.slack.com/methods/files.upload)

Constant: \DZunke\SlackBundle\Slack\Client::ACTION_FILES_UPLOAD

``` php
protected $parameter = [
    'content'         => null,
    'filetype'        => null,
    'filename'        => null,
    'title'           => null,
    'initial_comment' => null,
    'channels'        => null   # If no Channel is given the File will be private to the API-User
];
```

## users.list

[Slack Documentation](https://api.slack.com/methods/users.list)

Constant: \DZunke\SlackBundle\Slack\Client::ACTION_USERS_LIST

``` php
protected $parameter = [
    'presence' => 1
];
```
