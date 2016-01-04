<?php

namespace Myexp\Bundle\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Product controller.
 *
 * @Route("/product")
 */
class ProductController extends Controller {

    /**
     * Finds and displays a Product entity.
     *
     * @Route("/view-{id}.html", name="product_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {

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

    /**
     * Finds and display product entities by category.
     *
     * @Route("/{name}.html", name="product_list")
     * @Method("GET")
     * @Template()
     */
    public function listAction($name) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpCmsBundle:Category')->findOneBy(array(
            'name' => $name
        ));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        //当前列表的顶级分类
        $topCategory = $entity->getTopCategory();

        //分页处理
        $productRepo = $this->getDoctrine()->getManager()->getRepository('MyexpCmsBundle:Product');
        $params = array(
            'category' => $entity,
            'isActive' => true
        );
        $productTotal = $productRepo->getProductCount($params);
        $paginator = new Paginator($productTotal);
        $paginator->setShowLimit(false);

        $sorts = array('p.updateTime' => 'DESC');
        $entities = $productRepo->getProductsWithPagination(
                $params, $sorts, $paginator->getOffset(), $paginator->getLimit()
        );

        return array(
            'entities' => $entities,
            'paginator' => $paginator,
            'category' => $entity,
            'topCategory' => $topCategory
        );
    }

}
