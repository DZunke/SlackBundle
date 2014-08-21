# Symfony SlackBundle - Full Slack Integration

## Install

Add the Bundle to the composer.json by running

    php composer.phar require dzunke/slack-bundle:dev-master

To enable upcoming Symfony-Features install the Bundle at Symfony's AppKernel

``` php
public function registerBundles()
{
    $bundles = [
        // [..]
        new DZunke\SlackBundle\DZunkeSlackBundle(),
    ];
}
```

## Basic-Usage

``` php
$identity = new Identity();
$identity->setUsername('Testuser');

$connection = new Connection();
$connection->setEndpoint('slack.com/api/');
$connection->setToken('##API-KEY##');

$client = new Client($connection);
$client->addIdentity($identity);

$client->send(
    Client\Actions::ACTION_POST_MESSAGE,
    [
        'channel' => '#slack-testing',
        'text' => 'TEST'
    ],
    'Testuser'
);
```

## License

SlackBundle is licensed under the MIT license.
