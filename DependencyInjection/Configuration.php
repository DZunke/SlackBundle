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
            ->scalarNode('endpoint')->defaultValue('slack.com/api/')->end()
            ->scalarNode('token')->isRequired()->cannotBeEmpty()->end()
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
            ->useAttributeAsKey('name')
            ->cannotBeEmpty()
            ->prototype('array');


        $microservicesNode
            ->children()
            ->scalarNode('icon_url')->defaultNull()->end()
            ->scalarNode('icon_emoji')->defaultNull()->end()
            ->end();

        return $node;
    }


}
