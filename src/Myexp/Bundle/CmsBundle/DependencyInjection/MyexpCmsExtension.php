<?php

namespace Myexp\Bundle\CmsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MyexpCmsExtension extends Extension implements PrependExtensionInterface {

    /**
     * 
     * @param array $config
     * @param ContainerBuilder $container
     * @return \Myexp\Bundle\CmsBundle\DependencyInjection\Configuration
     */
    public function getConfiguration(array $config, ContainerBuilder $container) {
        return new Configuration($container->getParameter('kernel.debug'));
    }

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container) {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('config.yml');
        $loader->load('services.yml');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);
        
        $container->setParameter('myexp_cms.enabled_locales', $config['enabled_locales']);
        $container->setParameter('myexp_cms.content_models', $config['content_models']);
        $container->setParameter('myexp_cms.url_rewrite', $config['url_rewrite']);
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
                        'MyexpCmsBundle:layout:form-theme.html.twig'
                    )
                )
            );
        }

        //覆盖默认分页主题
        if (isset($bundles['KnpPaginatorBundle'])) {
            $container->prependExtensionConfig(
                'knp_paginator', array(
                    'template' => array(
                        'pagination' => 'MyexpCmsBundle:layout:form-theme.html.twig'
                    )
                )
            );
        }
    }

}
