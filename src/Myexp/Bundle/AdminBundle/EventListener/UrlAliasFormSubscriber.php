<?php

namespace Myexp\Bundle\AdminBundle\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Myexp\Bundle\AdminBundle\Entity\UrlAlias;

/**
 * Description of UrlAliasFormSubscriber
 *
 * @author kai
 */
class UrlAliasFormSubscriber implements EventSubscriberInterface {

    /**
     *
     * @var type 
     */
    private $manager;

    /**
     *
     * @var type 
     */
    private $action;

    /**
     * 
     * @param ObjectManager $manager
     */
    public function __construct(ObjectManager $manager, $action) {
        $this->manager = $manager;
        $this->action = $action;
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
        $entity = $event->getData();
        $form = $event->getForm();

        if (null === $entity) {
            return;
        }

        $urlAlias = $entity->getUrlAlias();

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
        $entity = $event->getData();

        $contentModel = $entity->getContentModel();
        $urlAlias = $entity->getUrlAlias();
        $url = $form->get('urlAliasUrl')->getData();

        if (null !== $url && null !== $urlAlias) {

            //更新
            $urlAlias->setUrl($url);
        } elseif (null !== $urlAlias) {

            //删除
            $entity->setUrlAlias(null);
            $this->manager->remove($urlAlias);
            $this->manager->flush();
        } elseif (null !== $url) {

            //新增
            if ('show' == $this->action) {
                $path = $contentModel
                        ->getDefaultShowRoute(false)
                        ->getPath();
            } else {
                $path = $contentModel
                        ->getDefaultListRoute(false)
                        ->getPath();
            }

            $urlAlias = new UrlAlias();
            $urlAlias->setUrl($url);
            $urlAlias->setPath($path);

            $entity->setUrlAlias($urlAlias);
        }
    }

}
