<?php

namespace Myexp\Bundle\CmsBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * DownlaodCategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends EntityRepository {

    public function getChildren($parent = null) {
        $qb = $this->createQueryBuilder('c');

        if ($parent === null) {
            $qb->where('c.parent IS NULL');
        } else {
            $qb
                    ->where('c.parent = ?1')
                    ->setParameter('1', $parent)
            ;
        }
        $qb->add('orderBy', 'c.sortOrder ASC');
        return $qb->getQuery()->getResult();
    }

    public function setIsactive() {
        $qb = $this->createQueryBuilder('i')
                ->where('i.isActive != :isActive')
                ->setParameter('isActive', NULL)
                ->getQuery();

        return $qb->getResult();
    }

}
