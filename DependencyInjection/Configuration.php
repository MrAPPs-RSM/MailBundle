<?php

namespace Mrapps\MailBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('mrapps_mail');
        
        
        $rootNode
                ->children()
                    ->arrayNode('general')
                        ->children()
                            ->scalarNode('manager_type')->defaultValue('orm')->end()
                        ->end()
                    ->end()
                ->end();

        return $treeBuilder;
    }
}
