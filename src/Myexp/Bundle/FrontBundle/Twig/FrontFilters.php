<?php

namespace Myexp\Bundle\FrontBundle\Twig;

/**
 * 前台显示需要的过滤器
 *
 * @author Kevin
 */
class FrontFilters {

    /**
     *
     * @var FrontExtension
     */
    protected $ext;

    /**
     * 
     * @param FrontExtension $ext
     */
    public function __construct(FrontExtension $ext) {
        $this->ext = $ext;
    }

    /**
     * 高亮关键字
     * 
     * @param type $text
     * @param type $keyword
     */
    public function highlight($text, $keyword) {
        return $text;
    }

}
