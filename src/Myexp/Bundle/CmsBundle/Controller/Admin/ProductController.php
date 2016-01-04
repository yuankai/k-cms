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
class ProductController extends AdminController {

    /**
     *
     * 主菜单
     * 
     * @var type 
     */
    protected $primaryMenu = 'admin_product';

    /**
     * Finds and displays a Product entity.
     *
     * @Route("/", name="admin_product")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {

        $pageRepo = $this->getDoctrine()->getManager()->getRepository('MyexpCmsBundle:Page');

        $params = array();

        $pageTotal = $pageRepo->getPageCount($params);
        $sorts = array('a.createDate' => 'DESC', 'a.id' => 'DESC');
        $entities = $pageRepo->getPagesWithPagination(
                $params, $sorts, 0, 10
        );

        return $this->display(array(
                    'entities' => $entities,
        ));
    }

}
