<?php

namespace Myexp\Bundle\CmsBundle\EventListener;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Myexp\Bundle\CmsBundle\Entity\Content;

/**
 * Description of ContentListener
 *
 * @author kai
 */
class ContentEntitySubscriber implements EventSubscriber {

    /**
     *
     * @var type 
     */
    private $tokenStorage;

    /**
     * 
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage) {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * 需要订阅的事件
     * 
     * @return type
     */
    public function getSubscribedEvents() {
        return array(
            'prePersist',
            'preUpdate',
            'postPersist',
            'postUpdate',
        );
    }

    /**
     * 保存前操作
     * 
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args) {
        if ($this->checkEntity($args)) {
            $this->updateTimeAndUser($args);
        }
    }

    /**
     * 更新前操作
     * 
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args) {
        if ($this->checkEntity($args)) {
            $this->updateTimeAndUser($args);
        }
    }

    /**
     * 更新操作时间以及操作人
     * 
     * @param LifecycleEventArgs $args
     * @return type
     * @throws \LogicException
     */
    private function updateTimeAndUser(LifecycleEventArgs $args) {

        $entity = $args->getEntity();

        //当前用户
        $user = $this->tokenStorage->getToken()->getUser();
        if (!$user) {
            throw new \LogicException(
            'The create action cannot be used without an authenticated user!'
            );
        }

        //创建及更新时间
        if (!$entity->getCreateTime()) {
            $entity->setCreateTime(new \DateTime());
        }

        $entity->setUpdateTime(new \DateTime());

        //创建及更新者
        if (!$entity->getCreatedBy()) {
            $entity->setCreatedBy($user);
        }
        $entity->setUpdateBy($user);
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
     * 保存内容后继操作
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

        //只针对内容实体
        if ($entity instanceof Content) {
            return TRUE;
        }

        return FALSE;
    }

}
