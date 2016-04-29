<?php

namespace Myexp\Bundle\AdminBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class MyexpAdminExtension extends Extension implements PrependExtensionInterface {

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container) {
        
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        // 导入新的widget
        $container->setParameter('twig.form.resources', 
            array_merge(
                $container->getParameter('twig.form.resources'), 
                array(
                    'MyexpAdminBundle:Chips:new_widget.html.twig'
                )
            )
        );
    }

    /**
     * Allow an extension to prepend the extension configurations.
     * 
     * @param ContainerBuilder $container
     */
    public function prepend(ContainerBuilder $container) {
        
        $bundles = $container->getParameter('kernel.bundles');

        // 覆盖默认表单主题
        if (isset($bundles['TwigBundle'])) {
            $container->prependExtensionConfig(
                    'twig', array(
                        'form_theme' => array(
                            'MyexpAdminBundle:Chips:form_override.html.twig'
                        )
                    )
            );
        }

        //覆盖默认分页主题
        if (isset($bundles['KnpPaginatorBundle'])) {
            $container->prependExtensionConfig(
                    'knp_paginator', array(
                        'page_range' => 5,
                        'default_options' => array(
                            'page_name' => 'page',
                            'sort_field_name' => 'sort',
                            'sort_direction_name' => 'direction',
                            'distinct' => true
                        ),
                        'template' => array(
                            'pagination' => 'MyexpAdminBundle:Chips:pagination.html.twig',
                            'sortable' => 'MyexpAdminBundle:Chips:sortable_link.html.twig'
                        )
                    )
            );
        }
    }

}
