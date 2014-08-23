# Help for Slack

## Token

To get your Token you need to be logged in into the Slack-System and visit the [API-Page](https://api.slack.com/).
There is a headline "Authentication" where your Team should be listet with the possibility to get a Token.

**Note:** The API-Token is linked to the user who redeems it. Maybe there should be a "System"-User in your Team for this purposes.

## Formatting Messages

There are some useful help for how you can format messages.

* [Enabled Markdown](https://slack.zendesk.com/hc/en-us/articles/202288908-How-can-I-add-formatting-to-my-messages-)
* [Emoji Cheat Sheet](http://www.emoji-cheat-sheet.com/)

## Notifications

To call Notifications for a User. First it must be enabled for the User. There are some Ways to notify:

* Message: _"Foo @everyone Bar"_, will notify everyone in at the Network. Must be Used on the #general Channel
* Message: _"Foo @channel Bar"_, will notify everyone in a Channel
* Message: _"Foo @Bazuser Bar"_, will notify the named User

## Rate-Limit

Officially the Slack-API has a [Rate Limit](https://api.slack.com/docs/rate-limits) for Requests. The API only allows
one Request per Second. For short times the API will ignore if you get over this limit but maybe there comes a time
the API will give an Error for this. In this Case the Client will automatically try it for two more times. If you want
to raise this loop of tries you can change it in the [Configuration](configuraton.md).
