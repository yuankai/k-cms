<?php

namespace Myexp\Bundle\CmsBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Myexp\Bundle\CmsBundle\Entity\Menu;
use Myexp\Bundle\CmsBundle\Controller\MenuController;

/**
 * Default controller.
 *
 * @Route("/admin")
 */
class DefaultController extends Controller {

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
