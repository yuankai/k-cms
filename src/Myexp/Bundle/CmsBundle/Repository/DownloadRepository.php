<?php

namespace Myexp\Bundle\CmsBundle\Repository;

use Myexp\Bundle\AdminBundle\Repository\ContentRepository;


/**
 * DownloadRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DownloadRepository extends ContentRepository {

    /**
     * 获得分页查询
     * 
     * @param type $params
     * @return type
     */
    public function getPaginationQuery($params = null) {
        $qb = $this->buildQuery($params);
        $qb->addOrderBy('c.createTime', 'DESC');

        return $qb->getQuery();
    }

    /**
     * 构造查询
     * 
     * @param type $params
     * @return type
     */
    public function buildQuery($params) {

        $qb = $this->createQueryBuilder('q');
        
        //添加内容过滤
        $this->buildContentQuery($qb, $params);

        return $qb;
    }

}
