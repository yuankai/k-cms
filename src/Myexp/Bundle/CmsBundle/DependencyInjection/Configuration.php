<?php

namespace Myexp\Bundle\CmsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Description of Configuration
 *
 * @author Kevin
 */
class Configuration implements ConfigurationInterface {
    
    /**
     *
     * @var type 
     */
    private $debug;
    
    /**
     * 
     * @param type $debug
     */
    public function __construct($debug) {
        $this->debug = (bool)$debug;
    }

    /**
     *  配置结构
     * 
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder() {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('myexp_cms');

        $rootNode
            ->children()
                
                ->arrayNode('enabled_locales')->end()
                
            ->end()
        ;

        return $treeBuilder;
    }

}
