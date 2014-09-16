# Services

## Messaging

Sending Messages to Channel, Group or User without the need of knowing the Client

``` php
$response = $container->get('dz.slack.messaging')->message(
    '#foo-channel',
    'Good Morning, please make sure u got a coffee before working!',
    'CoffeeBrewer'
);
```

There is also a way to use the "Attachment"-Feature of Slack. In this Case there will be a multi-column part below the Message.
For this you must create deliver an Array of Attachments to the Message-Method.

``` php
$attachment = new Attachment();
$attachment->setColor('danger');
$attachment->addField('Test1', 'Test works');

$response = $container->get('dz.slack.messaging')->message(
    '#foo-channel',
    'Good Morning, please make sure u got a coffee before working!',
    'CoffeeBrewer',
    [$attachment]
);
```

## Channels

There are some operations you can do for a Channel. It is necessary to get the ChannelId from the Slack-API before you
can do the Actions. If you do not have the Channel Ids you can execute the Debug-Command or simply execute getId() of
this Service.


``` php
$service = $container->get('dz.slack.channels');

# get the specific id of a channel
$service->getId($channelName);

# list all available channels in your team
$service->listAll();

# get information about just a single channel
$service->info($channelId);

# set the topic of a channel
$service->setTopic($channelId, $newTopic);
```

