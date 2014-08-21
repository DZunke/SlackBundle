# Symfony SlackBundle

The Bundle will integrate [Slack](https://slack.com/) Team-Communication-Software into your Symfony2 Project. 

**Table of Contents**  *generated with [DocToc](http://doctoc.herokuapp.com/)*

- [Symfony SlackBundle](#user-content-symfony-slackbundle)
	- [Install](#user-content-install)
	- [Basic-Usage](#user-content-basic-usage)
	- [Symfony](#user-content-symfony)
		- [Configuration](#user-content-configuration)
		- [Use Client-Service in Controller](#user-content-use-client-service-in-controller)
		- [Available Services for direct usage](#user-content-available-services-for-direct-usage)
	- [Slack Help](#user-content-slack-help)
		- [Formatting Messages](#user-content-formatting-messages)
		- [Notifications](#user-content-notifications)
	- [License](#user-content-license)

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

### Available Services for direct usage

**Messaging-Service** - Sending Messages to Channel, Group or User.

``` php
$response = $container->get('dz.slack.messaging')->message(
    '#slack-testing',
    'Good Morning, please make sure u got a coffee before working!',
    'CoffeeBrewer'
);
```

### Monolog Handler

First is to Create a Custom Handler-Service

``` yaml
# app/config.yml
services:
    my_custom_handler:
        class: DZunke\SlackBundle\Monolog\Handler\SlackHandler
        # 400 = ERROR, see Monolog::Logger for the values of log levels
        arguments: [@dz.slack.messaging, "#slack-testing", "Bazuser", 400]
```

Second is to give the Handler to the Monolog Configuration

``` yaml
# app/config.yml
monolog:
    handlers:
        slack:
            type: service
            id: my_custom_handler
```

## Slack Help

### Formatting Messages

There are some useful help for how you can format messages. 

  * [Enabled Markdown](https://slack.zendesk.com/hc/en-us/articles/202288908-How-can-I-add-formatting-to-my-messages-)
  * [Emoji Cheat Sheet](http://www.emoji-cheat-sheet.com/)

### Notifications

To call Notifications for a User. First it must be enabled for the User. There are some Ways to notify:

 * Message: _"Foo @everyone Bar"_, will notify everyone in at the Network. Must be Used on the #general Channel
 * Message: _"Foo @channel Bar"_, will notify everyone in a Channel
 * Message: _"Foo @Bazuser Bar"_, will notify the named User

## License

SlackBundle is licensed under the MIT license.
