<?php

namespace Myexp\Bundle\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Default controller.
 *
 * @Route("/")
 */
class DefaultController extends Controller {

    /**
     * Home page.
     *
     * @Route("/", name="homepage")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request) {
        
        //传值
        return array(
           'a'=>'b'
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
