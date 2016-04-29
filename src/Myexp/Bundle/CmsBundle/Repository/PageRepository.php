<?php

namespace Myexp\Bundle\CmsBundle\Repository;

use Myexp\Bundle\AdminBundle\Repository\ContentRepository;

/**
 * PageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PageRepository extends ContentRepository {

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

    public function getPageCount($params = null) {

        $qb = $this->buildQuery($params);
        $qb->select($qb->expr()->count('a'));

        return $qb->getQuery()->getSingleScalarResult();
    }

    private function buildQuery($params) {

        $qb = $this->createQueryBuilder('a');

        if (isset($params['page'])) {
            $qb
                    ->andWhere('a.page = ?1')
                    ->setParameter(1, $params['page'])
            ;
        }
        if (isset($params['isActive'])) {
            $qb
                    ->andWhere('a.isActive = ?2')
                    ->setParameter(2, $params['isActive'])
            ;
        }

        return $qb;
    }

}
