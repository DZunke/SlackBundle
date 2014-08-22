# Installation

## 1. Install the Bundle

You can add the Bundle by running [Composer](http://getcomposer.org) on your shell or adding it directly to your composer.json

``` bash
php composer.phar require dzunke/slack-bundle:dev-master
```

``` json
"require" :  {
    "dzunke/slack-bundle": "dev-master"
}
```

## 2. Register the Bundle to Symfony

The Namespace will be registered by autoloading with Composer but to use the integrated features for symfony you have to register the Bundle.

``` php
# app/AppKernel.php
public function registerBundles()
{
    $bundles = [
        // [..]
        new DZunke\SlackBundle\DZunkeSlackBundle(),
    ];
}
```

## 3. Add the Configuration for the Bundle

To use the Bundle without an Error you have to add the Connection-Data and finally one Identity to use with the Methods like MonologHandler or Messaging.

``` yaml
# app/config/config.yml
d_zunke_slack:
    token: "YOUR AUTH-TOKEN"
    identities:
        CoffeeBrewer: ~
```

