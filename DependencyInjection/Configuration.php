<?php

namespace Xsolve\UnitSkelgenBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('xsolve_unit_skelgen');

        $rootNode
            ->children()
                ->scalarNode('bin')
                    ->defaultValue('phpunit-skelgen')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
