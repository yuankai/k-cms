<?php

namespace Myexp\Bundle\CmsBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Myexp\Bundle\CmsBundle\Entity\Content;

/**
 * Description of ContentListener
 *
 * @author kai
 */
class ContentSubscriber implements EventSubscriber {

    /**
     * 需要订阅的事件
     * 
     * @return type
     */
    public function getSubscribedEvents() {
        return array(
            'postPersist',
            'postUpdate',
        );
    }

    /**
     * 更新后继操作
     * 
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args) {
        $this->updateUrlAlias($args);
    }

    /**
     * 保存内容后继操作
     * 
     * @param LifecycleEventArgs $args
     * @return type
     */
    public function postPersist(LifecycleEventArgs $args) {
        $this->updateUrlAlias($args);
    }

    /**
     * 
     * 更新url别名
     * 
     * @param LifecycleEventArgs $args
     * @return type
     */
    private function updateUrlAlias(LifecycleEventArgs $args) {
        $entity = $args->getEntity();

        // only act on some "Content" entity
        if (!$entity instanceof Content) {
            return;
        }

        $entityManager = $args->getEntityManager();
        $urlAlias = $entity->getUrlAlias();

        if (null !== $urlAlias) {
            $parameters = array('id' => $entity->getId());
            $urlAlias->setParameters(json_encode($parameters));
            $entityManager->persist($urlAlias);
            $entityManager->flush();
        }
    }

}
