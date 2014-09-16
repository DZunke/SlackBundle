<?php

namespace DZunke\SlackBundle\Silex\Provider;

use DZunke\SlackBundle\Monolog\Handler\SlackHandler;
use DZunke\SlackBundle\Slack\Client;
use DZunke\SlackBundle\Slack\Messaging;
use Silex\Application;
use Silex\Provider\MonologServiceProvider;
use Silex\ServiceProviderInterface;

class SlackServiceProvider implements ServiceProviderInterface
{

    public function register(Application $app)
    {
        $default_options = [
            'endpoint'      => 'slack.com/api/',
            'token'         => null,
            'limit_retries' => 5,
            'identities'    => [
                'Silex' => []
            ],
            'logging'       => [
                'enabled'  => false,
                'channel'  => '',
                'identity' => ''
            ]
        ];

        if (isset($app['dz.slack.options'])) {
            $app['dz.slack.options'] = array_merge($default_options, $app['dz.slack.options']);
        } else {
            $app['dz.slack.options'] = $default_options;
        }

        $app['dz.slack.identity_bag'] = $app->share(
            function ($app) {
                $identityBag = new Messaging\IdentityBag();
                $identityBag->createIdentities($app['dz.slack.options']['identities']);

                return $identityBag;
            }
        );

        $app['dz.slack.connection'] = $app->share(
            function ($app) {
                $connection = new Client\Connection();
                $connection->setEndpoint($app['dz.slack.options']['endpoint']);
                $connection->setLimitRetries($app['dz.slack.options']['limit_retries']);
                $connection->setToken($app['dz.slack.options']['token']);

                return $connection;
            }
        );

        $app['dz.slack.client'] = $app->share(
            function ($app) {
                return new Client($app['dz.slack.connection']);
            }
        );

        $app['dz.slack.messaging'] = $app->share(
            function ($app) {
                return new Messaging($app['dz.slack.client'], $app['dz.slack.identity_bag']);
            }
        );

        if ($app['dz.slack.options']['logging']['enabled']) {

            $app['monolog.handler.slack'] = $app->share(
                function ($app) {
                    $level = MonologServiceProvider::translateLevel($app['monolog.level']);

                    return new SlackHandler(
                        $app['dz.slack.messaging'],
                        $app['dz.slack.options']['logging']['channel'],
                        $app['dz.slack.options']['logging']['identity'],
                        $level
                    );
                }
            );

            $app['monolog']->pushHandler($app['monolog.handler.slack']);

        }
    }

    public function boot(Application $app)
    {

    }

}
