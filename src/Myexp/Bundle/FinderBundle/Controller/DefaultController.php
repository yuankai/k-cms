<?php

namespace Myexp\Bundle\FinderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MyexpFinderBundle:Default:index.html.twig');
    }
}
