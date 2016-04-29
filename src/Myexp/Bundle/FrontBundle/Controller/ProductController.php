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
class ProductController extends FrontController {

    /**
     * All products.
     *
     * @Route("/services.html", name="product_all")
     * @Method("GET")
     * @Template("MyexpFrontBundle:Product:all.html.twig")
     */
    public function allAction(Request $request) {

        $repository = $this
                ->getDoctrine()
                ->getRepository('MyexpCmsBundle:Product')
        ;

        $query = $repository->getPaginationQuery();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $query, $request->get('page', 1), 10
        );
        $pagination->setTemplate($this->getPaginationTpl());
        
        $data = array(
            'pagination' => $pagination
        );

        return $this->display($data);
    }

}
