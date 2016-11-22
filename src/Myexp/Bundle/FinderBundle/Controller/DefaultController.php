<?php

namespace Myexp\Bundle\FinderBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Myexp\Bundle\AdminBundle\Controller\AdminController;

/**
 * Finder controller.
 *
 * @Route("/")
 */
class DefaultController extends AdminController {

    /**
     *
     * 主菜单
     * 
     * @var type 
     */
    protected $primaryMenu = 'finder_default';

    /**
     * Finder index
     *
     * @Route("/", name="finder_default")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request) {
        return $this->display();
    }

}
