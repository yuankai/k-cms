<?php

namespace Myexp\Bundle\AdminBundle\Form\DataTransformer;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Description of EntityToIdTransformer
 *
 * @author kai
 */
class EntityToIdTransformer implements DataTransformerInterface {

    /**
     *
     * @var type 
     */
    private $manager;

    /**
     *
     * @var type 
     */
    private $class;

    /**
     * 
     * @param ObjectManager $manager
     * @param type $class
     */
    public function __construct(ObjectManager $manager, $class) {
        $this->manager = $manager;
        $this->class = $class;
    }

    /**
     * 
     * entity转换为id
     * 
     * @param type $entity
     */
    public function transform($entity) {

        if (null === $entity) {
            return '';
        }

        return $entity->getId();
    }

    /**
     * id转换为实体
     * 
     * @param type $id
     * @return type
     * @throws TransformationFailedException
     */
    public function reverseTransform($id) {

        if (!$id) {
            return;
        }

        $entity = $this->manager
                ->getRepository($this->class)
                ->find($id)
        ;

        if (null === $entity) {
            throw new TransformationFailedException(sprintf(
                    'An entity with id "%s" does not exist!', $entity
            ));
        }

        return $entity;
    }

}
