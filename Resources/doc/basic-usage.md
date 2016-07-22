# Basic Usage without Symfony Integration

The Basic-Integration of Slack in this Bundle is usable without Symfony.

``` php
$identity = new \DZunke\SlackBundle\Slack\Client\Identity();
$identity->setUsername('CoffeeBrewer');
$identity->setIconEmoji(':coffee:');

$connection = new \DZunke\SlackBundle\Slack\Client\Connection();
$connection->setEndpoint('slack.com/api/');
$connection->setToken('YOUR API TOKEN');

$client = new \DZunke\SlackBundle\Slack\Client($connection);

$response = $client->send(
    \DZunke\SlackBundle\Slack\Client\Actions::ACTION_POST_MESSAGE,
    [
        'identity' => $identity
        'channel' => '#slack-testing',
        'text'    => 'Good Morning, please make sure u got a coffee before working!'
    ]
);
```
