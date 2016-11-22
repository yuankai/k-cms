<?php

namespace Myexp\Bundle\AdminBundle\Repository;

/**
 * ContentStatusRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ContentStatusRepository extends \Doctrine\ORM\EntityRepository {

    /**
     * 根据内容类型获得状态
     * 
     * @param type $contentModel
     * @return type
     */
    public function getByContentModel($contentModel) {

        $qb = $this->createQueryBuilder('s')
                ->where('s.contentModel = :cm')
                ->setParameter('cm', $contentModel)
                ->orWhere('s.contentModel is null')
        ;

        return $qb->getQuery()->execute();
    }

}
