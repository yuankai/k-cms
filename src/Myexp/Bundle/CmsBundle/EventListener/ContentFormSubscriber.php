<?php

namespace Myexp\Bundle\CmsBundle\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Myexp\Bundle\CmsBundle\Entity\ContentModelInterface;
use Myexp\Bundle\CmsBundle\Form\DataTransformer\UrlAliasTransformer;

/**
 * Description of ContentFormSubscriber
 *
 * @author Kevin
 */
class ContentFormSubscriber implements EventSubscriberInterface {
    
/**
     *
     * @var type 
     */
    private $manager;

    /**
     *
     * @var type 
     */
    private $session;

    /**
     * 
     * @param ObjectManager $manager
     */
    public function __construct(ObjectManager $manager, Session $session) {
        $this->manager = $manager;
        $this->session = $session;
    }
    
    /**
     * 
     * @return type
     */
    public static function getSubscribedEvents() {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData'
        );
    }

    /**
     * 
     * @param FormEvent $event
     */
    public function preSetData(FormEvent $event) {

        $currentForm = $event->getForm();
        $parentForm = $currentForm->getParent();
        $parentData = $parentForm->getData();

        if (!$parentData instanceof ContentModelInterface) {
            return;
        }

        //获得模型实体
        $contentModelName = $parentData->getContentModelName();
        $contentModelEntity = $this->manager
                ->getRepository('MyexpCmsBundle:ContentModel')
                ->findOneBy(array('name' => $contentModelName));

        //只有可分类模型才添加分类字段
        if (!$contentModelEntity->getIsClassable()) {
            $currentForm->remove('category');
        }

        //添加url别名转换器
//        $currentForm->get('urlAlias')->addModelTransformer(new UrlAliasTransformer(
//                $this->manager, $contentModelEntity
//        ));

        //设置表单的内容类型
        $currentForm->get('contentModel')->setData($contentModelEntity);

        //设置当前网站
        $website = $this->session->get('currentWebsite');
        $currentForm->get('website')->setData($website);
        
        //内容状态
        $contentStatuses = $this->manager
                ->getRepository('MyexpCmsBundle:ContentStatus')
                ->getByContentModel($contentModelEntity);
        
        $currentForm->add('contentStatus', EntityType::class, array(
            'label' => 'content.status',
            'class' => 'MyexpCmsBundle:ContentStatus',
            'choice_label' => 'title',
            'choices' => $contentStatuses
        ));
    }

}
