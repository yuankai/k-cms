<?php

namespace Myexp\Bundle\FrontBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends FrontController {

    /**
     * Lists all Page entities.
     *
     * @Route("/search", name="search")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request) {

        $keyword = $request->get('k');
        $em = $this->getDoctrine()->getManager();

        //如果关键词为空转到首页
        if (empty($keyword)) {
            return $this->redirect($this->generateUrl('homepage'));
        }
        
        $contentModelRep = $em->getRepository('MyexpAdminBundle:ContentModel');

        $contentModelId = $request->get('c');
        if ($contentModelId) {
            $contentModel = $contentModelRep->find($contentModelId);
        }
        
        $contentModels = $contentModelRep->findAll();

        $qb = $em
                ->getRepository('MyexpAdminBundle:Content')
                ->createQueryBuilder('c')
        ;

        //限定内容类型
        if ($contentModelId) {
            $qb
                    ->where('c.contentModel = :contentModel')
                    ->setParameter('contentModel', $contentModel)
            ;
        }

        //匹配字段
        $qb
                ->andWhere($qb->expr()->orX(
                        $qb->expr()->like('c.title', ':keyword'),
                        $qb->expr()->like('c.keywords', ':keyword'),
                        $qb->expr()->like('c.description', ':keyword')
                ))
                ->setParameter('keyword', '%' . $keyword . '%')
                ->getQuery()
        ;

        //分页
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $qb->getQuery(), $request->query->getInt('page', 1)
        );

        return $this->display(array(
            'contentModels'=> $contentModels,
            'pagination' => $pagination
        ));
    }

}
