<?php

namespace Myexp\Bundle\AdminBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * 控制器相关监听
 */
class ControllerListener {

    /**
     * 
     * 执行前置操作
     * 
     * @param FilterControllerEvent $event
     * @return type
     */
    public function onKernelController(FilterControllerEvent $event) {

        $controllers = $event->getController();
        $currentController = $controllers[0];

        if (method_exists($currentController, 'before')) {
            $currentController->before();
        }
    }

}
