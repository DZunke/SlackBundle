# Services

## Messaging

Sending Messages to Channel, Group or User without the need of knowing the Client

``` php
$response = $container->get('dz.slack.messaging')->message(
    '#slack-testing',
    'Good Morning, please make sure u got a coffee before working!',
    'CoffeeBrewer'
);
```
