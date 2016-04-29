<?php

namespace Myexp\Bundle\AdminBundle\EventListener;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Filesystem\Filesystem;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Myexp\Bundle\AdminBundle\Entity\UrlAlias;

/**
 * Description of UrlAliasEntitySubscriber
 *
 * @author kai
 */
class UrlAliasEntitySubscriber implements EventSubscriber {

    /**
     *
     * @var type 
     */
    private $router;

    /**
     *
     * @var type 
     */
    private $filesystem;

    /**
     *
     * @var type 
     */
    private $cacheDir;

    /**
     * 
     * @param Router $router
     * @param Filesystem $filesystem
     * @param String $cacheDir
     */
    public function __construct(Router $router, Filesystem $filesystem, $cacheDir) {
        $this->router = $router;
        $this->filesystem = $filesystem;
        $this->cacheDir = $cacheDir;
    }

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
        if ($this->checkEntity($args)) {
            $this->clearRouteCache();
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
            $this->clearRouteCache();
        }
    }

    /**
     * 
     * 清理路由缓存
     * 
     * @return type
     */
    private function clearRouteCache() {

        foreach (array('matcher_cache_class', 'generator_cache_class') as $option) {
            $className = $this->router->getOption($option);
            $cacheFile = $this->cacheDir . DIRECTORY_SEPARATOR . $className . '.php';
            $this->filesystem->remove($cacheFile);
        }

        $this->router->warmUp($this->cacheDir);
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
        if ($entity instanceof UrlAlias) {
            return TRUE;
        }

        return FALSE;
    }

}
