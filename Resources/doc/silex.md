# Silex Integration

In the Bundle there is a SilexProvider you can use with your Silex-Application. There is no need to get an extra Package. The Provider delivers the following Extensions:

    $app['dz.slack.connection']   # Slack/Client/Connection.php
    $app['dz.slack.client']       # Slack/Client.php
    $app['dz.slack.identity_bag'] # Slack/Messaging/IdentityBag.php
    $app['dz.slack.messaging']    # Slack/Messaging.php
    
To configure the SlackBundle in Silex there is the need to set some Configuration-Values

``` php
$app['dz.slack.options'] = [
    'token'         => 'YOUR TOKEN HERE,
    'identities'    => [
        'YOUR IDENTITIY' => []
    ],
    'logging'       => [
        'enabled'  => true,
        'channel'  => 'YOUR CHANNEL TO LOG TO',
        'identity' => 'THE IDENTITY TO LOG WITH'
    ]
];
```

Wit these Options set you can load the Provider in your index

``` php
$app->register(new DZunke\SlackBundle\Silex\Provider\SlackServiceProvider());
``` 

## Monolog Integration

If you want to integrate the SlackHandler to an Instance of Monolog be sure the logging is enabled in the config. In that case the Provider will try to add the Handler to the default Logger ```$app['monolog']```. It will use the same LogLevel as the default Logger.

Be sure that the MonologProvider is handled before!
