<?php

namespace Myexp\Bundle\CmsBundle\Repository;

/**
 * 内容模型接口
 *
 * @author kai
 */
interface ContentModel {

    /**
     * 获得默认路由
     */
    public function getDefaultRoute($urlSurffix);
}
