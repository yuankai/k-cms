<?php

namespace Myexp\Bundle\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Base front controller.
 *
 */
class FrontController extends Controller {

    /**
     *
     * @var type 
     */
    protected $currentWebsite;

    /**
     * 前置操作
     */
    public function before() {

        $websiteId = $this->getParameter('website_id');

        $website = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('MyexpAdminBundle:Website')
                ->find($websiteId);

        $this->currentWebsite = $website;
    }

    /**
     * 显示页面
     * 
     * @param array $data
     * @return type
     */
    public function display($data = array()) {

        $data['website'] = $this->currentWebsite;

        return $data;
    }
    
    /**
     * 
     * 获得
     * 
     * @return string
     */
    public function getPaginationTpl(){
        return 'MyexpFrontBundle:Common:pagination.html.twig';
    }

}
