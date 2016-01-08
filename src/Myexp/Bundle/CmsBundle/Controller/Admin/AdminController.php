<?php

namespace Myexp\Bundle\CmsBundle\Controller\Admin;

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
     * 默认列表
     * 
     * @param \Myexp\Bundle\CmsBundle\Controller\Admin\Request $request
     * @param type $entityName
     * @param type $params
     * @return type
     */
    public function index($params = array()) {
        
        if(empty($this->primaryEntity)){
            return $this->display(array());
        }

        $request = $this->container->get('request_stack')->getCurrentRequest();

        $repo = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository($this->primaryEntity);

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
    public function redirectSucceed($url, $status = 302) {

        $this->get('session')->getFlashBag()->add('notice', 'common.success');

        return parent::redirect($url, $status);
    }

}
