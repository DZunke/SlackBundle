<?php

namespace DZunke\SlackBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('d_zunke_slack');
        $rootNode->children()
            ->scalarNode('endpoint')
                ->defaultValue('https://slack.com/api')
            ->end()
            ->scalarNode('token')
                ->isRequired()
                ->defaultNull()
                ->cannotBeEmpty()
            ->end()
            ->integerNode('limit_retries')
                ->defaultValue(3)
                ->min(1)
                ->info('The amount of retries for the connection if the Rate Limits of Slack are reached')
            ->end()
        ->end();

        $rootNode->append($this->addIdentities());

        return $treeBuilder;
    }

    /**
     * @return ArrayNodeDefinition|\Symfony\Component\Config\Definition\Builder\NodeDefinition
     */
    private function addIdentities()
    {
        $treeBuilder = new TreeBuilder();
        $node        = $treeBuilder->root('identities');

        /** @var $connectionNode ArrayNodeDefinition */
        $microservicesNode = $node->requiresAtLeastOneElement()
            ->useAttributeAsKey('username')
            ->cannotBeEmpty()
            ->info('Usernames to use for Communication inside the Messaging')
            ->prototype('array');


        $microservicesNode
            ->children()
                ->scalarNode('icon_url')
                    ->defaultNull()
                    ->info('An Url to a specific picture to use as Icon')
                ->end()
                ->scalarNode('icon_emoji')
                    ->defaultNull()
                    ->info('The Icon to use from an emoji like :smile:')
                ->end()
            ->end();

        return $node;
    }


}
