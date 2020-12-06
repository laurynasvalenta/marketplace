<?php

namespace Shared\ProductClientBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('product_client');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('api_base_url')
                    ->isRequired(true)
                ->end()
            ->end();

        return $treeBuilder;
    }
}
