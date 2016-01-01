<?php

namespace Myexp\Bundle\CmsBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Default controller.
 *
 * @Route("/admin")
 */
class DefaultController extends AdminController {
    
    /**
     *
     * 主菜单
     * 
     * @var type 
     */
    protected $primaryMenu = 'admin_homepage';

    /**
     * Home page.
     *
     * @Route("/", name="admin_homepage")
     * @Security("has_role('ROLE_USER')")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        return array();
    }
}
