<?php

namespace Myexp\Bundle\CmsBundle\Controller;

use Myexp\Bundle\AdminBundle\Controller\AdminController;

/**
 * Cms controller.
 */
class CmsController extends AdminController {

    /**
     *
     * 路径前缀
     * 
     * @var type 
     */
    protected $pathPrefix = 'cms_';

    /**
     * Bundle名称
     * 
     * @var type 
     */
    protected $bundleName = 'MyexpCmsBundle';

}
