<?php

namespace Myexp\Bundle\CmsBundle\EventListener;

use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class ViewListener {

    protected $rewrite;
    protected $registry;

    public function __construct(RegistryInterface $registry, $rewrite) {
        $this->rewrite = $rewrite;
        $this->registry = $registry;
    }

    public function onKernelRequest(GetResponseEvent $event) {

        // 关闭url重写
        if (!$this->rewrite["on"]) {
            return;
        }

        $request = $event->getRequest();

        $requestUri = $request->getRequestUri();

        $em = $this->registry->getManager();
        // $em->getRepository("MyexpCmsBundle:QueryUrl");
    }

    /**
     * 
     * 为后台管理界面提供参数
     * 
     * @param FilterControllerEvent $event
     * @return type
     */
    public function onKernelController(FilterControllerEvent $event) {

        $controllers = $event->getController();
        $currentController = $controllers[0];

        $controllerObj = new \ReflectionObject($currentController);

        if (!($parentClass = $controllerObj->getParentClass())) {
            return;
        }

//        echo $controllerObj->getNamespaceName();
        
        $parentClassName = $parentClass->getShortName();
        if ($parentClassName !== 'AdminController') {
            return;
        }

        $currentController->before();
    }

    public function onKernelView(GetResponseForControllerResultEvent $event) {
        $result = $event->getControllerResult();


        //$data = array_merge($result['data'], array('myvar' => $this->myVar));
        //$rendered = $this->templating->render($result['template'], $data);
        //$event->setResponse(new Response($rendered));
    }

}
