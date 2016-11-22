<?php

namespace Myexp\Bundle\FinderBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Myexp\Bundle\FinderBundle\Elfinder\Connector;
use Myexp\Bundle\FinderBundle\Elfinder\Elfinder;

/**
 * Finder controller.
 *
 * @Route("/")
 */
class FinderController extends Controller {
    
    /**
     * Finder ckeditor
     *
     * @Route("/ckeditor", name="finder_ckeditor")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET")
     * @Template()
     */
    public function ckeditorAction(){
        return array();
    }
    
    /**
     * Finder dialog
     *
     * @Route("/dialog", name="finder_dialog")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET")
     * @Template()
     */
    public function dialogAction(Request $request){
        
        $callback = $request->get('callback');
        
        return array(
            'callback'=>$callback
        );
    }

    /**
     * Finder Connector 
     *
     * @Route("/connector", name="finder_connector")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET|POST")
     */
    public function connectorAction() {

        $uploadDir = realpath('./') . DIRECTORY_SEPARATOR . 'upload';
        if (!is_dir($uploadDir)) {
            @mkdir($uploadDir);
        }

        $opts = array(
            // 'debug' => true,
            'roots' => array(
                array(
                    'driver' => 'LocalFileSystem', // driver for accessing file system (REQUIRED)
                    'path' => $uploadDir, // path to files (REQUIRED)
                    'URL' => '/upload/', // URL to files (REQUIRED)
                    'uploadDeny' => array('all'), // All Mimetypes not allowed to upload
                    'uploadAllow' => array('image', 'text/plain'), // Mimetype `image` and `text/plain` allowed to upload
                    'uploadOrder' => array('deny', 'allow'), // allowed Mimetype `image` and `text/plain` only
                    'accessControl' => function($attr, $path, $data, $volume) {
                        // if file/folder begins with '.' (dot)
                        // set read+write to false, other (locked+hidden) set to true
                        // disable and hide dot starting files (OPTIONAL)
                        return strpos(basename($path), '.') === 0 ? !($attr == 'read' || $attr == 'write') : null;
                    }
                )
            )
        );

        $connector = new Connector(new Elfinder($opts));
        $connector->run();
    }

}
