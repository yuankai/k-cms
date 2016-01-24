<?php

namespace Myexp\Bundle\CmsBundle\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Myexp\Bundle\CmsBundle\Entity\ContentModel;
use Myexp\Bundle\CmsBundle\Entity\UrlAlias;

/**
 * Description of UrlAliasSubscriber
 *
 * @author kai
 */
class UrlAliasSubscriber implements EventSubscriberInterface {

    /**
     *
     * @var type 
     */
    private $manager;

    /**
     *
     * @var type 
     */
    private $contentModelEntity;

    /**
     * 
     * @param ContentModel $contentModelEntity
     */
    public function __construct(ObjectManager $manager, ContentModel $contentModelEntity) {
        $this->manager = $manager;
        $this->contentModelEntity = $contentModelEntity;
    }

    /**
     * 
     * @return type
     */
    public static function getSubscribedEvents() {
        return array(
            FormEvents::POST_SET_DATA => 'postSetData',
            FormEvents::SUBMIT => 'submit'
        );
    }

    /**
     * 
     * @param FormEvent $event
     */
    public function postSetData(FormEvent $event) {
        $content = $event->getData();
        $form = $event->getForm();

        if (null === $content) {
            return;
        }

        $urlAlias = $content->getUrlAlias();

        if (null !== $urlAlias) {
            $form->get('urlAliasUrl')->setData($urlAlias->getUrl());
        }
    }

    /**
     * 
     * @param FormEvent $event
     */
    public function submit(FormEvent $event) {

        $form = $event->getForm();
        $content = $event->getData();

        $urlAlias = $content->getUrlAlias();
        $url = $form->get('urlAliasUrl')->getData();

        if (null !== $url && null !== $urlAlias) {

            //更新
            $urlAlias->setUrl($url);
        } elseif (null !== $urlAlias) {

            //删除
            $content->setUrlAlias(null);
            $this->manager->remove($urlAlias);
            $this->manager->flush();
        } elseif (null !== $url) {

            //新增
            $showPath = $this->contentModelEntity
                    ->getDefaultShowRoute(false)
                    ->getPath();
            
            $urlAlias = new UrlAlias();
            $urlAlias->setUrl($url);
            $urlAlias->setPath($showPath);

            $content->setUrlAlias($urlAlias);
        }
    }

}
