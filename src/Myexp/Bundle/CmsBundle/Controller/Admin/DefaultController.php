<?php

namespace Myexp\Bundle\CmsBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
     * @Route("/", name="homepage")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        
               
        //传值
        return array(
           
        );
    }

    /**
     * Chage language.
     *
     * @Route("/locale", name="locale")
     * @Method("GET")
     */
    public function localeAction() {
        $locale = $this->getRequest()->query->get('l', 'zh');
        $this->getRequest()->getSession()->set('_locale', $locale);

        return new Response('OK');
    }

}
