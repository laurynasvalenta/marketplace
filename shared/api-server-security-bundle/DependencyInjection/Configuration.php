<?php

namespace Shared\ApiServerSecurityBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public const API_JWT_ENCRYPTION_KEY = 'api_jwt_encryption_key';

    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('api_security');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode(self::API_JWT_ENCRYPTION_KEY)
                    ->isRequired(true)
                ->end()
            ->end();

        return $treeBuilder;
    }
}
