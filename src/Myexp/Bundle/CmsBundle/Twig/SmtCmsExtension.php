<?php

namespace Myexp\Bundle\CmsBundle\Twig;

use Myexp\Bundle\CmsBundle\Helper\Upload;
use Myexp\Bundle\CmsBundle\Helper\Common;

class SmtCmsExtension extends \Twig_Extension {

    public function getName() {
        return 'smt_cms_extension';
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
            'week' => new \Twig_Function_Method($this, 'week'),
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

    /**
     * 星期几
     */
    public function week() {
        switch (date('N')) {
            case 1:
                echo '星期一';
                break;
            case 2:
                echo '星期二';
                break;
            case 3:
                echo '星期三';
                break;
            case 4:
                echo '星期四';
                break;
            case 5:
                echo '星期五';
                break;
            case 6:
                echo '星期六';
                break;
            case 7:
                echo '星期日';
                break;
        }
    }

}
