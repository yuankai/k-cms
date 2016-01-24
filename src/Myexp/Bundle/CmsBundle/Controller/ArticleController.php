<?php

namespace Myexp\Bundle\CmsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Myexp\Bundle\CmsBundle\Entity\Article;
use Myexp\Bundle\CmsBundle\Form\ArticleType;

/**
 * Article controller.
 *
 * @Route("/article")
 */
class ArticleController extends Controller {

    /**
     * Lists Article entities.
     *
     * @Route("/list/{id}", name="article_list")
     * @Method("GET")
     * @Template()
     */
    public function listAction() {

        $articleRepo = $this->getDoctrine()->getManager()->getRepository('MyexpCmsBundle:Article');

        $params = array();

        $articleTotal = $articleRepo->getArticleCount($params);

        $sorts = array('a.createDate' => 'DESC', 'a.id' => 'DESC');
        $entities = $articleRepo->getArticlesWithPagination(
                $params, $sorts, 0, 10
        );

        return array(
            'entities' => $entities,
        );
    }


    /**
     * Finds and displays a Article entity.
     *
     * @Route("/show/{id}/{page}", name="article_show", defaults={"page"=1})
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MyexpCmsBundle:Article')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Article entity.');
        }

        //分类
        $category = $entity->getCategory();
        $topCategory = $category->getTopCategory();

        return array(
            'entity' => $entity,
            'category' => $category,
            'topCategory' => $topCategory
        );
    }
}
