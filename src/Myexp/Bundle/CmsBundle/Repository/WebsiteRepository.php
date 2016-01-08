<?php

namespace Myexp\Bundle\CmsBundle\Repository;

/**
 * WebsiteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class WebsiteRepository extends \Doctrine\ORM\EntityRepository {

    /**
     * 获得分页查询
     * 
     * @param type $params
     * @return type
     */
    public function getPaginationQuery($params = null) {
        $qb = $this->buildQuery($params);

        return $qb->getQuery();
    }

    /**
     * 构造查询
     * 
     * @param type $params
     * @return type
     */
    public function buildQuery($params) {

        $qb = $this->createQueryBuilder('w');

        return $qb;
    }

}
