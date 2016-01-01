<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', 'text', array(
                    'label' => false,
                    'attr' => array('size' => 80)
                ))
                ->add('parent', 'entity', array(
                    'label' => 'category.parent',
                    'class' => 'MyexpCmsBundle:Category',
                    'property' => 'trans.title',
                    'required' => false
                ))
                ->add('name', 'text', array(
                    'label' => 'category.name',
                    'attr' => array('size' => 80)
                ))
                ->add('sortOrder', 'integer', array(
                    'label' => 'category.order',
                    'required' => false,
                    'attr' => array('class' => 'number')
                ))
                ->add('isActive', 'checkbox', array(
                    'label' => 'category.is_active',
                    'required' => false
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\CmsBundle\Entity\Category'
        ));
    }

    public function getName() {
        return 'myexp_bundle_cmsbundle_category';
    }

}
