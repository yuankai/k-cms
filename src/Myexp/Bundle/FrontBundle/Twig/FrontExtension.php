<?php

namespace Myexp\Bundle\FrontBundle\Twig;

use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * 网站模板扩展
 * 
 * @author Kevin Yuan <kai.yuan@foxmail.com>
 */
class FrontExtension extends \Twig_Extension {

    /**
     *
     * @var \Doctrine\Common\Persistence\ObjectManager 
     */
    protected $manager;

    /**
     *
     * @var \Symfony\Bundle\FrameworkBundle\Routing\Router 
     */
    private $router;
    
    /**
     *
     * @var type 
     */
    private $rewriteConfig;

    /**
     *
     * @var type 
     */
    private $frontFunctions;

    /**
     *
     * @var type 
     */
    private $frontFilters;

    /**
     * 
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry, Router $router, $rewriteConfig) {
        $this->manager = $registry->getManager();
        $this->router = $router;
        $this->rewriteConfig = $rewriteConfig;
        $this->frontFunctions = new FrontFunctions($this);
        $this->frontFilters = new FrontFilters($this);
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'myexpfront.front.extension';
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters() {
        return array(
            new \Twig_SimpleFilter('highlight', array($this->frontFilters, 'highlight')),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions() {
        return array(
            new \Twig_SimpleFunction('front_url', array($this->frontFunctions, 'getFrontUrl')),
            new \Twig_SimpleFunction('menu', array($this->frontFunctions, 'getMenuItems')),
            new \Twig_SimpleFunction('node', array($this->frontFunctions, 'getNodes')),
            new \Twig_SimpleFunction('category', array($this->frontFunctions, 'getCategories')),
            new \Twig_SimpleFunction('slider', array($this->frontFunctions, 'getSliders')),
            new \Twig_SimpleFunction('product', array($this->frontFunctions, 'getProducts')),
            new \Twig_SimpleFunction('article', array($this->frontFunctions, 'getArticles')),
            new \Twig_SimpleFunction('page', array($this->frontFunctions, 'getPage')),
        );
    }

    /**
     * 获得manager
     */
    public function getManager() {
        return $this->manager;
    }

    /**
     * 获得路由
     */
    public function getRouter() {
        return $this->router;
    }
    
    /**
     * 获得rewrite配置
     */
    public function getRewriteConfig() {
        return $this->rewriteConfig;
    }

}
