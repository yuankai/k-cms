<?php

namespace Myexp\Bundle\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Myexp\Bundle\CmsBundle\Entity\Menu;
use Myexp\Bundle\CmsBundle\Controller\MenuController;

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
    public function indexAction() {
        
        //实体仓库
        $em = $this->getDoctrine()->getRepository('CmsBundle:Article');
        
        //通知
        $notices = $em->getTitles(3, 6);

        //学科建设
        $constructions = $em->getTitles(10, 8);

        //首页图片新闻汇总
        $query = $em->createQueryBuilder('p')
                ->where('p.picurl != :picurl')
                ->setParameters(array('picurl'=> 'null'))
                ->orderBy('p.id', 'DESC')
                ->setMaxResults(5)
                ->getQuery();
        $pics = $query->getResult();

        //中心news
        $centers = $em->getTitles(1, 8);

        //行业industry
        $industrys = $em->getTitles(2, 8);
               
        //传值
        return array(
            'notices' => $notices,
            'constructions' => $constructions,
            'pics' => $pics,
            'centers' => $centers,
            'industrys' => $industrys,
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
