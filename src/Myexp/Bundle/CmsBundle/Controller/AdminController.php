<?php

namespace Myexp\Bundle\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Admin controller.
 *
 * @Route("/admin")
 */
class AdminController extends Controller {

    /**
     * Show administration default page.
     *
     * @Route("/", name="admin")
     * @Secure(roles="ROLE_ADMIN_USER")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        return array();
    }

}
