<?php

namespace Myexp\Bundle\CmsBundle\Form\DataTransformer;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

use Myexp\Bundle\CmsBundle\Entity\ContentModel;
use Myexp\Bundle\CmsBundle\Entity\UrlAlias;

/**
 * Description of UrlAliasTransformer
 *
 * @author kai
 */
class UrlAliasTransformer implements DataTransformerInterface {

    /**
     *
     * @var type 
     */
    private $manager;
    
    /**
     *
     * @var type 
     */
    private $model;

    /**
     * 
     * @param ObjectManager $manager
     * @param ContentModel $model
     */
    public function __construct(ObjectManager $manager, ContentModel $model) {
        $this->manager = $manager;
        $this->model = $model;
    }

    /**
     * 
     * entity转换为路径
     * 
     * @param type $entity
     */
    public function transform($entity) {

        if (null === $entity) {
            return '';
        }

        return $entity->getUrl();
    }

    /**
     * 路径转换为实体
     * 
     * @param type $url
     * @return type
     * @throws TransformationFailedException
     */
    public function reverseTransform($url) {

        if (!$url) {
            return;
        }
        
        $clearUrl = trim($url);

        $entity = $this->manager
                ->getRepository('MyexpCmsBundle:UrlAlias')
                ->findOneBy(array('url' => $clearUrl))
        ;

        if (null === $entity) {
            
            $controller = $this->model->getControllerName();
            
            $entity = new UrlAlias();
            $entity->setUrl($url);
            $entity->setController($controller);
            $entity->setParameters('{}');
        }

        return $entity;
    }

}
