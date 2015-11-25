<?php

namespace Myexp\Bundle\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Myexp\Bundle\CmsBundle\Entity\Article;
use Myexp\Bundle\CmsBundle\Entity\ArticleTranslation;
use Myexp\Bundle\CmsBundle\Form\ArticleType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller {

    /**
     * Lists all Page entities.
     *
     * @Route("/search", name="search")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {

        $keyword = $this->getRequest()->query->get('keyword');

        //如果关键词为空转到首页
        if (empty($keyword)) {
            return $this->redirect($this->generateUrl('homepage'));
        }

        $em = $this->getDoctrine()->getManager()->getRepository('SmtCmsBundle:ArticleTranslation');
        $entities = $em->getResults($keyword);

        $stat = array(
            'keyword' => $keyword
        );
        return array(
            'stat' => $stat,
            'entities' => $entities
        );
    }

}
