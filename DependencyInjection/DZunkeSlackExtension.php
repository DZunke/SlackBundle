<?php

namespace DZunke\SlackBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class DZunkeSlackExtension extends Extension
{
    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config        = $this->processConfiguration($configuration, $configs);

        $container->setParameter('d_zunke_slack.config', $config);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $this->configureSlackIdentityBag($config, $container);
        $this->configureSlackConnection($config, $container);
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    protected function configureSlackIdentityBag(array $config, ContainerBuilder $container)
    {
        $definition = $container->getDefinition('dz.slack.identity_bag');

        $definition->addMethodCall('createIdentities', [$config['identities']]);
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    protected function configureSlackConnection(array $config, ContainerBuilder $container)
    {
        $definition = $container->getDefinition('dz.slack.connection');

        $definition->addMethodCall('setEndpoint', [$config['endpoint']]);
        $definition->addMethodCall('setToken', [$config['token']]);
        $definition->addMethodCall('setLimitRetries', [$config['limit_retries']]);
        $definition->addMethodCall('setVerifySsl', [$config['verify_ssl']]);
    }

}
