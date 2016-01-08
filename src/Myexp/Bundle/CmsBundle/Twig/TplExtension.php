<?php

namespace Myexp\Bundle\CmsBundle\Twig;

use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * 网站模板扩展
 * 
 * @author Kevin Yuan <kai.yuan@foxmail.com>
 */
class TplExtension extends \Twig_Extension {
 
    /**
     *
     * @var \Doctrine\Common\Persistence\ObjectManager 
     */
    protected $manager;

    /**
     * 
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry) {
        $this->manager = $registry->getManager();
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions() {
        return array(
            new \Twig_SimpleFunction('article', array($this, 'getArticles')),
            new \Twig_SimpleFunction('article', array($this, 'getArticles')),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'myexpcms.tpl.extension';
    }
    
    /**
     * 获得文章
     * 
     * @param array $conditions
     */
    public function getArticles($conditions, $sort){
        
        $articles = array();
        $defaultConditions = array(
            
        );
        
        $repos = $this->manager->getRepository('MyexpCmsBundle:Article');
        
        
        return $articles;
    }

}
