<?php
/**
 * Author: Adrian Szuszkiewicz <me@imper.info>
 * Github: https://github.com/imper86
 * Date: 18.11.2019
 * Time: 11:51
 */

namespace Imper86\MessengerMiddlewaresBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class Imper86MessengerMiddlewaresExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        if ($config['unique']['enabled'] ?? false) {
            $this->loadUniqueMiddleware($loader, $container, $config['unique']);
        }

        if ($config['delay']['enabled'] ?? false) {
            $loader->load('delay_middleware.xml');
        }
    }

    private function loadUniqueMiddleware(XmlFileLoader $loader, ContainerBuilder $container, array $config): void
    {
        $loader->load('unique_middleware.xml');

        if ('imper86.messenger.redis_lock_repository' === $config['repository_service']) {
            $loader->load('redis_lock_repository.xml');

            if (null !== $config['redis_service']) {
                $container->getDefinition('imper86.messenger.redis_lock_repository')
                    ->setArgument(0, new Reference($config['redis_service']));
            }
        }

        $lockRepositoryReference = new Reference($config['repository_service']);

        $container->getDefinition('imper86.messenger.middleware.unique')
            ->setArgument(0, $lockRepositoryReference);

        $container->getDefinition('imper86.messenger.event_listener.unique')
            ->setArgument(0, $lockRepositoryReference);
    }
}
