<?php

namespace PSD\Bundle\ElasticSearchBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class CouchBaseExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        foreach($config['conexiones'] as $id => $connection) {
            $this->createElasticSearchDefinition($container, $id, $connection);
        }
    }

    private function createElasticSearchDefinition(ContainerBuilder $container, $id, $configuration)
    {        
        $provider = 'elasticsearch.' . $id;
        $container
            ->setDefinition(
                $provider,
                new DefinitionDecorator('elasticsearch')
            )
            ->replaceArgument(0, $configuration['hosts'])
        ;
    }
}
