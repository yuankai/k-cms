<?php

namespace Myexp\Bundle\FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Product controller.
 * 
 * @Route("/")
 */
class PageController extends FrontController {

    /**
     * About us.
     *
     * @Route("/about.html", name="page_about")
     * @Method("GET")
     * @Template("MyexpFrontBundle:Page:about.html.twig")
     */
    public function aboutAction(Request $request) {

        $repository = $this
                ->getDoctrine()
                ->getRepository('MyexpCmsBundle:Page')
        ;

        $entity = $repository->find(2);

        $data = array(
            'entity' => $entity
        );

        return $this->display($data);
    }
    
    /**
     * Contact us.
     *
     * @Route("/contact.html", name="page_contact")
     * @Method("GET")
     * @Template("MyexpFrontBundle:Page:contact.html.twig")
     */
    public function contactAction(Request $request) {

        $repository = $this
                ->getDoctrine()
                ->getRepository('MyexpCmsBundle:Page')
        ;

        $entity = $repository->find(1);

        $data = array(
            'entity' => $entity
        );
        
        return $this->display($data);
    }

}
