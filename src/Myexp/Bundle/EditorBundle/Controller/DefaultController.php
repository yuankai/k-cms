<?php

namespace Myexp\Bundle\EditorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {

    public function indexAction() {
        return $this->render('MyexpEditorBundle:Default:index.html.twig');
    }

}
