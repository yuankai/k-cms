<?php

namespace Myexp\Bundle\CmsBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Admin base controller.
 */
abstract class AdminController extends Controller {

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
     * 默认列表
     * 
     * @param \Myexp\Bundle\CmsBundle\Controller\Admin\Request $request
     * @param type $entityName
     * @param type $params
     * @return type
     */
    public function index($params = array()) {

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

        return $this->display(array(
                    'pagination' => $pagination
        ));
    }

    /**
     * Creates a form to create a Node entity.
     *
     * @param Node $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    protected function createCreateForm($entity) {

        $route = $this->getRouteByAction('create');

        $form = $this->createForm($this->primaryFormType, $entity, array(
            'action' => $this->generateUrl($route),
            'method' => 'POST',
        ));

        $form->add('submit', SubmitType::class, array('label' => 'common.create'));

        return $form;
    }

    /**
     * Creates a form to edit a Node entity.
     *
     * @param Node $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    protected function createEditForm($entity) {

        $route = $this->getRouteByAction('update');

        $form = $this->createForm($this->primaryFormType, $entity, array(
            'action' => $this->generateUrl($route, array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', SubmitType::class, array('label' => 'common.update'));

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
     * 显示界面
     * 
     * @param type $data
     * @return type
     */
    public function display($data) {

        if ($this->primaryMenu) {
            $data['primaryMenu'] = $this->primaryMenu;
        }

        return $data;
    }

    /**
     * 跳转并提示信息
     * 
     * @param type $url
     * @param type $status
     */
    public function redirectSucceed($url = '', $status = 302) {

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

        $route = 'admin_' . strtolower($this->primaryEntity);

        if (empty($action)) {
            return $route;
        }

        return $route . '_' . $action;
    }

    /**
     * 获得完整实体名称
     * 
     * @return type
     */
    private function getFullEntityName() {
        return 'MyexpCmsBundle:' . $this->primaryEntity;
    }
    
    /**
     * Ajax 方式显示数据
     * 
     * @param type $data
     */
    protected function ajaxDisplay($data = array()){
        
        $result = array('code'=>'ok');
        
        if(!empty($data['errors'])){
            $result['code'] = 'error';
        }
        
        $finalResult = array_merge($result, $data);
        
        return new Response(json_encode($finalResult));
    }

}
