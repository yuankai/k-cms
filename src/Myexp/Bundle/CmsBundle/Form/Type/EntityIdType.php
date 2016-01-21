<?php

namespace Myexp\Bundle\CmsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Doctrine\Common\Persistence\ObjectManager;
use Myexp\Bundle\CmsBundle\Form\DataTransformer\EntityToIdTransformer;

/**
 * 实体ID类型
 */
class EntityIdType extends AbstractType {

    /**
     *
     * @var type 
     */
    protected $manager;

    /**
     * 
     * @param ObjectManager $manager
     */
    public function __construct(ObjectManager $manager) {
        $this->manager = $manager;
    }

    /**
     * 
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->addModelTransformer(new EntityToIdTransformer(
                $this->manager, $options['class']
        ));
    }

    /**
     * 
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setRequired(array(
            'class'
        ));
    }

    /**
     * 
     * @return type
     */
    public function getParent() {
        return HiddenType::class;
    }

}
