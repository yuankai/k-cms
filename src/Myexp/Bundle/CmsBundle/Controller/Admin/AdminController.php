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

}
