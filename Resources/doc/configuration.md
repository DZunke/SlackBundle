# Configuration Reference

``` yaml
d_zunke_slack:
    endpoint:             slack.com/api/
    token:                null # Required

    # The amount of retries for the connection if the Rate Limits of Slack are reached
    limit_retries:        3

    # Usernames to use for Communication inside the Messaging
    identities:

        # Prototype
        username:

            # An Url to a specific picture to use as Icon
            icon_url:             null

            # The Icon to use from an emoji like :smile:
            icon_emoji:           null

```
