<?php

namespace Myexp\Bundle\CmsBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * 视图相关监听
 */
class ViewListener {

    /**
     *
     * @var type 
     */
    private $rewrite;

    /**
     *
     * @var type 
     */
    private $manager;

    /**
     *
     * @var type 
     */
    private $session;

    /**
     * 
     * @param ObjectManager $manager
     * @param Session $session
     * @param type $rewrite
     */
    public function __construct(ObjectManager $manager, Session $session, $rewrite) {
        $this->manager = $manager;
        $this->session = $session;
        $this->rewrite = $rewrite;
    }

    /**
     * 
     * @param GetResponseEvent $event
     * @return type
     */
    public function onKernelRequest(GetResponseEvent $event) {

        $request = $event->getRequest();
        $requestUri = $request->getRequestUri();

        //管理界面
        if (preg_match('/^\/admin/', $requestUri)) {

            //设置当前管理的站点
            $currentWebsite = $this->session->get('currentWebsite');

            if (!$currentWebsite) {

                //获得默认站点到session
                $allWebsites = $this->manager->getRepository('MyexpCmsBundle:Website')->findAll();
                $this->session->set('currentWebsite', $allWebsites[0]);
            }

            return;
        }

        /*
         * 前端界面
         */

        // 关闭url重写
        if (!$this->rewrite["on"]) {
            return;
        }

        //echo $requestUri;
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

        $namespace = $controllerObj->getNamespaceName();

        //判断是否为后台界面
        if (!preg_match('/Admin$/', $namespace)) {
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
