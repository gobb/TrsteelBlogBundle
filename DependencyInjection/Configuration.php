<?php

namespace Trsteel\BlogBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('trsteel_blog');

		$rootNode
			->children()
				->arrayNode('panels')
					->addDefaultsIfNotSet()
					->children()
						->arrayNode('categories')
							->addDefaultsIfNotSet()
							->children()
								->booleanNode('must_have_posts')->defaultTrue()->end()
								->booleanNode('show_post_count')->defaultTrue()->end()
							->end()
						->end()
						->arrayNode('archive')
							->addDefaultsIfNotSet()
							->children()
								->booleanNode('must_have_posts')->defaultFalse()->end()
								->booleanNode('show_post_count')->defaultTrue()->end()
								->scalarNode('number_of_months')->defaultValue(12)->end()
							->end()
						->end()
					->end()
				->end()
			->end()
		;
        return $treeBuilder;
    }
}
