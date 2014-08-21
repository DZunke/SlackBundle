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
$identity = new \DZunke\SlackBundle\Slack\Client\Identity();
$identity->setUsername('CoffeeBrewer');
$identity->setIconEmoji(':coffee:');

$identityBag = new \DZunke\SlackBundle\Slack\Client\IdentityBag();
$identityBag->addIdentity($identity);

$connection = new \DZunke\SlackBundle\Slack\Client\Connection();
$connection->setEndpoint('slack.com/api/');
$connection->setToken('YOUR API TOKEN5');

$client = new \DZunke\SlackBundle\Slack\Client($connection);
$client->setIdentityBag($identityBag);

$response = $client->send(
    \DZunke\SlackBundle\Slack\Client\Actions::ACTION_POST_MESSAGE,
    [
        'channel' => '#slack-testing',
        'text'    => 'Good Morning, please make sure u got a coffee before working!'
    ],
    'CoffeeBrewer'
);
```

## Symfony

### Configuration

``` yaml
# app/config.yml
d_zunke_slack:
    token: "YOUR API TOKEN"
    identities:
        CoffeeBrewer:
            icon_emoji: ":coffee:"
```

### Use Client-Service in Controller

``` php
# AcmeBundle/IndexController.php
public function messageAction()
{
    $client   = $this->get('dz.slack.client');
    $response = $client->send(
        \DZunke\SlackBundle\Slack\Client\Actions::ACTION_POST_MESSAGE,
        [
            'channel' => '#slack-testing',
            'text'    => 'Good Morning, please make sure u got a coffee before working!'
        ],
        'CoffeeBrewer'
    );
}
```

## License

SlackBundle is licensed under the MIT license.
