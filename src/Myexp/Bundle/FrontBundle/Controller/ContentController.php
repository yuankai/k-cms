<?php

namespace Myexp\Bundle\FrontBundle\Controller;

/**
 * Content controller.
 */
class ContentController extends FrontController {

    /**
     * Lists Content entities.
     */
    public function listAction($model, $id, $page) {

        $contentModel = $this
                ->getDoctrine()
                ->getRepository('MyexpAdminBundle:ContentModel')
                ->findOneBy(array('name' => $model))
        ;

        $category = $this
                ->getDoctrine()
                ->getRepository('MyexpAdminBundle:Category')
                ->find($id)
        ;

        $entityName = $contentModel->getEntityName();
        $repository = $this
                ->getDoctrine()
                ->getRepository($entityName)
        ;

        $query = $repository
                ->getPaginationQuery(array(
                    'category' => $category
                ))
        ;

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $query, $page, 10
        );
        $pagination->setTemplate($this->getPaginationTpl());
        
        //节点路径
        $nodePath = $category->getDefaultPath();

        $view = 'MyexpFrontBundle:' . ucfirst($model) . ':list.html.twig';
        $data = array(
            'category' => $category,
            'nodePath' => $nodePath,
            'pagination' => $pagination
        );

        return $this->render($view, $this->display($data));
    }

    /**
     * Finds and displays a entity.
     */
    public function showAction($model, $id, $page) {
        
        $contentModel = $this
                ->getDoctrine()
                ->getRepository('MyexpAdminBundle:ContentModel')
                ->findOneBy(array('name' => $model))
        ;

        $content = $this
                ->getDoctrine()
                ->getRepository('MyexpAdminBundle:Content')
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
        
        //节点路径
        if($contentModel->getIsClassable()){
            $category = $entity->getCategory();
            $nodePath = $category->getDefaultPath();
        } else {
            $nodePath = $content->getDefaultPath();
        }

        $view = 'MyexpFrontBundle:' . ucfirst($model) . ':show.html.twig';
        $data = array('entity' => $entity, 'nodePath' => $nodePath);

        return $this->render($view, $this->display($data));
    }

}
