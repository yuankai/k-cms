<?php

namespace Myexp\Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MyexpAdminBundle:Default:index.html.twig');
    }
}
