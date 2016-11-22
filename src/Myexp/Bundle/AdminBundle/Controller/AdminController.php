<?php

namespace Myexp\Bundle\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Admin base controller.
 */
abstract class AdminController extends Controller {

    /**
     *
     * 路径前缀
     * 
     * @var type 
     */
    protected $pathPrefix = 'admin_';
    
    /**
     * Bundle名称
     * @var type 
     */
    protected $bundleName = 'MyexpAdminBundle';

    /**
     *
     * 主菜单
     * 
     * @var type 
     */
    protected $primaryMenu = '';

    /**
     * 主实体
     * 
     * @var type
     */
    protected $primaryEntity = '';

    /**
     * 主表单类型
     *
     * @var type 
     */
    protected $primaryFormType = '';

    /**
     * 查找表单类型
     *
     * @var type 
     */
    protected $findFormType = '';

    /**
     * 所有站点
     * @var type 
     */
    protected $allWebsites = array();

    /**
     * 当前站点
     * @var type
     */
    protected $currentWebsite;

    /**
     * 默认分页列表
     * 
     * @param \Myexp\Bundle\AdminBundle\Controller\Request $request
     * @param type $params
     * @return type
     */
    protected function getPagination($params = array()) {

        if (empty($this->primaryEntity)) {
            return $this->display(array());
        }

        $request = $this->container->get('request_stack')->getCurrentRequest();

        $repo = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository($this->getFullEntityName());

        $query = $repo->getPaginationQuery($params);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $query, $request->query->getInt('page', 1)
        );

        return $pagination;
    }

    /**
     * Creates a form to create a Node entity.
     *
     * @param Node $entity The entity
     * @param Boolean $addSubmit Add submit button
     *
     * @return \Symfony\Component\Form\Form The form
     */
    protected function createCreateForm($entity, $addSubmit = true) {

        $route = $this->getRouteByAction('create');

        $form = $this->createForm($this->primaryFormType, $entity, array(
            'action' => $this->generateUrl($route),
            'method' => 'POST'
        ));

        if ($addSubmit) {
            $form->add('submit', SubmitType::class, array('label' => 'common.create'));
        }

        return $form;
    }

    /**
     * Creates a form to edit a Node entity.
     *
     * @param Node $entity The entity
     * @param Boolean $addSubmit Add submit button
     *
     * @return \Symfony\Component\Form\Form The form
     */
    protected function createEditForm($entity, $addSubmit = true) {

        $route = $this->getRouteByAction('update');

        $form = $this->createForm($this->primaryFormType, $entity, array(
            'action' => $this->generateUrl($route, array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        if ($addSubmit) {
            $form->add('submit', SubmitType::class, array('label' => 'common.update'));
        }

        return $form;
    }

    /**
     * Creates a form to delete a Node entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    protected function createDeleteForm($id) {

        $route = $this->getRouteByAction('delete');

        return $this->createFormBuilder()
                        ->setAction($this->generateUrl($route, array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', SubmitType::class, array(
                            'label' => 'common.delete',
                            'attr' => array('class' => 'ui red button')))
                        ->getForm()
        ;
    }

    /**
     * Create a find form
     * 
     * @param type $addSubmit
     * @return \Symfony\Component\Form\Form The form
     */
    protected function createFindForm($addSubmit = true) {

        $route = $this->getRouteByAction();

        $form = $this->createForm($this->findFormType, null, array(
            'action' => $this->generateUrl($route),
            'method' => 'GET',
        ));

        if ($addSubmit) {
            $form->add('submit', SubmitType::class, array('label' => 'common.find'));
        }

        return $form;
    }

    /**
     * 前置操作
     */
    public function before() {

        //获得所有站点
        $em = $this->getDoctrine()->getManager();
        $allWebsites = $em->getRepository('MyexpAdminBundle:Website')->findAll();

        //获得当前站点
        $session = $this->get('session');
        $currentWebsite = $session->get('currentWebsite');

        if (!$currentWebsite) {
            $currentWebsite = $allWebsites[0];
            $session->set('currentWebsite', $currentWebsite);
        }

        $this->allWebsites = $allWebsites;
        $this->currentWebsite = $currentWebsite;
    }

    /**
     * 显示界面
     * 
     * @param type $data
     * @return type
     */
    protected function display($data = array()) {

        // 主菜单
        $data['primaryMenu'] = $this->getPrimaryMenu();
        
        //站点信息
        if ($this->currentWebsite) {
            $data['currentWebsite'] = $this->currentWebsite;
            $data['allWebsites'] = $this->allWebsites;
        }

        return $data;
    }

    /**
     * 跳转并提示信息
     * 
     * @param type $url
     * @param type $status
     */
    protected function redirectSucceed($url = '', $status = 302) {

        $this->get('session')->getFlashBag()->add('notice', 'common.success');

        if (empty($url)) {
            $url = $this->generateUrl($this->getRouteByAction());
        }

        return parent::redirect($url, $status);
    }

    /**
     * 根据action获得路由
     * 
     * @param type $action
     */
    private function getRouteByAction($action = '') {

        $route = $this->pathPrefix . strtolower($this->primaryEntity);

        if (empty($action)) {
            return $route;
        }

        return $route . '_' . $action;
    }

    /**
     * 获得实体名称
     * 
     * @return type
     */
    private function getFullEntityName() {
        return $this->bundleName.':'.ucwords($this->primaryEntity);
    }

    /**
     * Ajax 方式显示数据
     * 
     * @param type $data
     */
    protected function ajaxDisplay($data = array()) {

        $result = array('code' => 'ok');

        if (!empty($data['errors'])) {
            $result['code'] = 'error';
        }

        $finalResult = array_merge($result, $data);

        return new Response(json_encode($finalResult));
    }

    /**
     * 重新生成路由cache
     */
    protected function warmUpRouteCache() {

        $router = $this->get('router');
        $filesystem = $this->get('filesystem');
        $kernel = $this->get('kernel');
        $cacheDir = $kernel->getCacheDir();

        foreach (array('matcher_cache_class', 'generator_cache_class') as $option) {
            $className = $router->getOption($option);
            $cacheFile = $cacheDir . DIRECTORY_SEPARATOR . $className . '.php';
            $filesystem->remove($cacheFile);
        }

        $router->warmUp($cacheDir);
    }

    /**
     * 获得主菜单
     * 
     * @return type
     */
    public function getPrimaryMenu() {

        if ($this->primaryMenu) {
            return $this->primaryMenu;
        }

        return $this->pathPrefix . strtolower($this->primaryEntity);
    }

}
