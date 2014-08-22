# Monolog Integration

**Please only use this Log-Handler for Errors or Criticals**

In a first step you have to create a custom service for the Handler. In this Service you can define Channel and Username to work with. The Username must be registered in the [Configuration](configuration.md) to be usable otherwise you'll get an Exception.

``` yaml
# app/config.yml
services:
    my_custom_handler:
        class: DZunke\SlackBundle\Monolog\Handler\SlackHandler
        # 400 = ERROR, see Monolog::Logger for the values of log levels
        arguments: [@dz.slack.messaging, "#foo-channel", "bazuser", 400]
```

You can create a bunch of Handlers. To Register the Handler to the Main-Logging of Symfony you'll have to add the new Service to the Monolog Configuration.

``` yaml
# app/config.yml
monolog:
    handlers:
        slack:
            type: service
            id: my_custom_handler
```
