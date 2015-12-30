<?php

namespace Myexp\Bundle\CmsBundle\Twig;

use Myexp\Bundle\CmsBundle\Utils\Upload;
use Myexp\Bundle\CmsBundle\Utils\Common;

class CmsExtension extends \Twig_Extension {

    public function getName() {
        return 'cms_extension';
    }

    public function getFilters() {
        return array(
            new \Twig_SimpleFilter('picurl', array($this, 'picurlFilter')),
            new \Twig_SimpleFilter('fileurl', array($this, 'fileurlFiter')),
        );
    }

    public function getFunctions() {
        return array(
            'tree' => new \Twig_Function_Method($this, 'buildTreeFunction'),
            'leftnav' => new \Twig_Function_Method($this, 'combieCategoryAndPages')
        );
    }

    /**
     * 创建树状结构
     */
    public function buildTreeFunction($entities) {
        return Common::buildTree($entities);
    }

    /**
     * 合并分类和页面并排序
     */
    public function combieCategoryAndPages($categories, $pages) {
        return Common::combieCategoryAndPages($categories, $pages);
    }

    /**
     * 下载链接
     */
    public function fileurlFiter($path) {
        return Upload::getDownloadWebPath($path);
    }

    /**
     * 图片地址
     */
    public function picurlFilter($path) {
        return Upload::getWebPath($path);
    }

}
