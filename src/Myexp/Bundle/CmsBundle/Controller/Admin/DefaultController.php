<?php

namespace Myexp\Bundle\CmsBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
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
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request) {
        
        $websiteId = $request->get('websiteId');
        if ($websiteId) {
            $this->setCurrentWebsite($websiteId);
        }

        return $this->display(array());
    }

    /**
     * 
     * 设置当前网站
     * 
     * @param type $websiteId
     */
    public function setCurrentWebsite($websiteId) {

        $em = $this->getDoctrine();
        $website = $em->getRepository('MyexpCmsBundle:Website')->find($websiteId);

        // 保存当前网站到session
        $session = $this->get('session');
        $session->set('currentWebsite', $website);

        $this->currentWebsite = $website;
    }

}
