# Commands

## Debugging

Output of Debug Informations like Connection, Identities, Channels etc.

``` bash
php app/console dzunke:slack:debug
```

## Messaging

Sending a Message directly from Console

``` bash
php app/console dzunke:slack:message @fooUser BazUser "Lorem ipsum dolor sit amet .."
php app/console dzunke:slack:message "#FooChannel" BazUser "Lorem ipsum dolor sit amet .."
```
