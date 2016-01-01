<?php

namespace Myexp\Bundle\CmsBundle\EventListener;

use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

class ControllerListener {
    
    protected $templating;
    protected $primaryMenu;
    
    public function __construct(EngineInterface $templating) {
        $this->templating = $templating;
    }
    
    public function getPrimaryMenu(){
        return $this->primaryMenu;
    }
    
    public function onKernelView(GetResponseForControllerResultEvent $event){
        $result = $event->getControllerResult();
        
        
    }
    
}