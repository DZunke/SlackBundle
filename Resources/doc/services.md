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
$attachment = new DZunke\SlackBundle\Slack\Entity\MessageAttachment();
$attachment->setColor('danger');
$attachment->addField('Test1', 'Test works');

$response = $container->get('dz.slack.messaging')->message(
    '#foo-channel',
    'Good Morning, please make sure u got a coffee before working!',
    'CoffeeBrewer',
    [$attachment]
);
```

### File Uploads

The Messaging does include File Uploads. So the Service has an "upload"-Method to publish Reports or other Files to a Channel.
You must note that every uploaded File will be associated with the API-Key-User configured for your Slack-Client.

``` php
$response = $container->get('dz.slack.messaging')->upload(
    '#foo-channel',
    'Title for this File',
    '/Path/to/the/file',
    'Optional Comment'
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

## Users

To get more information about the users in your team there is a service to read user specific things. In lack of an
api method to load single users every method of the service will load the complete list of users in your team. Beware
of using this service without caching informations you often need.

``` php
$service = $container->get('dz.slack.users');

# get the list of all users in your team
$service->getUsers();

# get all users that are not deleted
$service->getActiveUsers();

# get all deleted users
$service->getDeletedUsers();

# get the id of a single user - needed for some actions
$service->getId($username);

```
