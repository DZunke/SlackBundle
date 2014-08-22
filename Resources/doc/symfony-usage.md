# Basic Usage in Symfony

If you followed the Setup you will have a bunch of services registered. For the Basic-Usage you only need the Client to execute all the Actions the Client has implemented.

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
