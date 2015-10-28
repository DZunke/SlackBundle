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

## Switch Topic of a Channel

You can switch the Topic of a Channel

``` bash
php app/console dzunke:slack:channels:topic "C02GABTDT" "Lorem ipsum dolor sit amet .."

# If you don't have the ChannelId it must be discovered while processing
php app/console dzunke:slack:channels:topic "#foo-channel" "Lorem ipsum dolor sit amet .." -d
```

## Read userdata from api

you will get a table of userdata.

``` bash
# Read all users from your team
php app/console dzunke:slack:users

# Read a single user
php app/console dzunke:slack:users --user=nameOfTheUser
```
