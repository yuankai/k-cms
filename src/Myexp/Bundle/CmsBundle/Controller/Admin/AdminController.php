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
    public function redirectSuccess($url, $status = 302) {
        
        $this->get('session')->getFlashBag()->add('notice', 'common.success');
        
        return parent::redirect($url, $status);
    }

}
