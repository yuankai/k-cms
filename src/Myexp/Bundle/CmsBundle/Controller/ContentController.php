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
 * Content controller.
 */
class ContentController extends Controller {

    /**
     * Lists Content entities.
     *
     * @Method("GET")
     */
    public function listAction($model, $id, $page) {

        var_dump($model, $id, $page);
    }

    /**
     * Finds and displays a Article entity.
     *
     */
    public function showAction($model, $id, $page) {

        $contentModel = $this
                ->getDoctrine()
                ->getRepository('MyexpCmsBundle:ContentModel')
                ->findOneBy(array('name' => $model))
        ;

        $content = $this
                ->getDoctrine()
                ->getRepository('MyexpCmsBundle:Content')
                ->find($id)
        ;

        $entityName = $contentModel->getEntityName();
        $repository = $this
                ->getDoctrine()
                ->getRepository($entityName)
        ;

        $query = $repository
                ->createQueryBuilder('c')
                ->where('c.content = :content')
                ->setParameter('content', $content)
                ->getQuery()
        ;

        $entity = $query->getOneOrNullResult();
        
        $view = 'MyexpCmsBundle:'.ucfirst($model).':show.html.twig';
        
        return $this->render($view, array('entity'=>$entity));
    }

}
