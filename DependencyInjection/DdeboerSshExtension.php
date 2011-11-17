<?php

namespace Ddeboer\SshBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Definition;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class DdeboerSshExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        foreach ($config['connections'] as $name => $connection) {
            $configuration = new Definition('Ddeboer\SshBundle\SshSessionBuilder');
            $configuration->setArguments(array($connection['host'], $connection['port']));

            if (isset($connection['authentication_password'])) {
                $configuration->addMethodCall('withPasswordAuthentication', array(
                    $connection['authentication_password']['username'],
                    $connection['authentication_password']['password']
                ));
            }

            $builderServiceName = sprintf('ddeboer_ssh.connections.%s.builder', $name);

            $container->setDefinition($builderServiceName, $configuration);

            $session = new Definition('Ssh\Session');
            $session->setFactoryService($builderServiceName)
                    ->setFactoryMethod('build');

            $container->setDefinition(sprintf('ddeboer_ssh.connections.%s', $name), $session);
        }

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }
}
