<?php

namespace Myexp\Bundle\FrontBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface {

    /**
     *
     * @var type 
     */
    private $debug;

    /**
     *
     * @var type 
     */
    private $locales = array('zh', 'en');

    /**
     * 
     * @param type $debug
     */
    public function __construct($debug) {
        $this->debug = (bool) $debug;
    }

    /**
     *  配置结构
     * 
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder() {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('myexp_front');

        $rootNode
                ->children()
                    ->arrayNode('enabled_locales')
                        ->defaultValue($this->locales)
                        ->prototype('scalar')
                    ->end()
                ->end()
        ;
      
        $rootNode
                ->children()
                    ->arrayNode('url_rewrite')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->booleanNode('on')->defaultTrue()->end()
                            ->scalarNode('url_suffix')->defaultValue('.html')->end()
                            ->booleanNode('page_in_first_link')->defaultFalse()->end()
                        ->end()
                    ->end()
                ->end()
        ;

        return $treeBuilder;
    }

}
