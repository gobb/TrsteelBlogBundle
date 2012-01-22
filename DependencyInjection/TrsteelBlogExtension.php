<?php

namespace Trsteel\BlogBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class TrsteelBlogExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

		$container->setParameter('trsteel_blog.panels.categories.must_have_posts', $config['panels']['categories']['must_have_posts']);
		$container->setParameter('trsteel_blog.panels.categories.show_post_count', $config['panels']['categories']['show_post_count']);
		
		$container->setParameter('trsteel_blog.panels.archive.must_have_posts', $config['panels']['archive']['must_have_posts']);
		$container->setParameter('trsteel_blog.panels.archive.show_post_count', $config['panels']['archive']['show_post_count']);
		$container->setParameter('trsteel_blog.panels.archive.number_of_months', $config['panels']['archive']['number_of_months']);

    }
}
