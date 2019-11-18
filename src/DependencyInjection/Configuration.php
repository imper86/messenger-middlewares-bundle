<?php
/**
 * Author: Adrian Szuszkiewicz <me@imper.info>
 * Github: https://github.com/imper86
 * Date: 18.11.2019
 * Time: 11:43
 */

namespace Imper86\MessengerMiddlewaresBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('imper86_messenger_middlewares');

        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            $rootNode = $treeBuilder->root('imper86_messenger_middlewares');
        }

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('unique')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')->defaultFalse()->end()
                        ->scalarNode('repository_service')->defaultValue('imper86.messenger.redis_lock_repository')->end()
                        ->scalarNode('redis_service')->defaultNull()->end()
                    ->end()
                ->end()
                ->arrayNode('delay')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')->defaultFalse()->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
