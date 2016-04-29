<?php

namespace Myexp\Bundle\AdminBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;

use Myexp\Bundle\AdminBundle\Entity\Category;

/**
 * Description of ContentListener
 *
 * @author kai
 */
class CategoryEntitySubscriber implements EventSubscriber {

    /**
     * 需要订阅的事件
     * 
     * @return type
     */
    public function getSubscribedEvents() {
        return array(
            'postUpdate',
            'postPersist',
        );
    }

    /**
     * 更新后继操作
     * 
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args) {
        if ($this->checkEntity($args)) {
            $this->updateUrlAlias($args);
        }
    }

    /**
     * 保存后继操作
     * 
     * @param LifecycleEventArgs $args
     * @return type
     */
    public function postPersist(LifecycleEventArgs $args) {
        if ($this->checkEntity($args)) {
            $this->updateUrlAlias($args);
        }
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
        $entityManager = $args->getEntityManager();

        $urlAlias = $entity->getUrlAlias();

        if (null !== $urlAlias) {

            $path = $urlAlias->getPath();
            $showPath = str_replace('{id}', $entity->getId(), $path);
            $urlAlias->setPath($showPath);

            $entityManager->persist($urlAlias);
            $entityManager->flush();
        }
    }

    /**
     * 只处理内容实体
     * 
     * @param LifecycleEventArgs $args
     * @return boolean
     */
    private function checkEntity(LifecycleEventArgs $args) {
        $entity = $args->getEntity();

        //只针对分类实体
        if ($entity instanceof Category) {
            return TRUE;
        }

        return FALSE;
    }

}
