<?php

namespace Myexp\Bundle\CmsBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Myexp\Bundle\CmsBundle\Helper\Paginator;

/**
 * Product controller.
 *
 * @Route("/admin/product")
 */
class ProductController extends Controller {

    /**
     * Finds and displays a Product entity.
     *
     * @Route("/", name="admin_product")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MyexpCmsBundle:Product')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        //当前分类的顶级分类
        $category = $entity->getCategory()->getTopCategory();

        return array(
            'entity' => $entity,
            'category' => $category
        );
    }


}
