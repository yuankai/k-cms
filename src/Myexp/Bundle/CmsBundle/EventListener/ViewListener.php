<?php

namespace Myexp\Bundle\CmsBundle\EventListener;

use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

class ViewListener {

    protected $rewrite;
    protected $registry;

    public function __construct(RegistryInterface $registry, $rewrite) {
        $this->rewrite = $rewrite;
        $this->registry = $registry;
    }

    public function onKernelRequest(GetResponseEvent $event) {
        
        // 关闭url重写
        if(!$this->rewrite["on"]){
            return;
        }

        $request = $event->getRequest();

        $requestUri = $request->getRequestUri();

        $em = $this->registry->getManager();
       // $em->getRepository("MyexpCmsBundle:QueryUrl");

        
    }

    public function onKernelView(GetResponseForControllerResultEvent $event) {
        $result = $event->getControllerResult();


        //$data = array_merge($result['data'], array('myvar' => $this->myVar));
        //$rendered = $this->templating->render($result['template'], $data);
        //$event->setResponse(new Response($rendered));
    }

}
