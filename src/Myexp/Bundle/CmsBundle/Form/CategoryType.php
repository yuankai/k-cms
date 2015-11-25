<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('parent', 'entity', array(
                    'label' => 'category.parent',
                    'class' => 'SmtCmsBundle:Category',
                    'property' => 'trans.title',
                    'required' => false
                ))
                ->add('name', 'text', array(
                    'label' => 'category.name',
                    'attr' => array('size' => 80)
                ))
                ->add('translations', 'collection', array(
                    'label' => 'category.title',
                    'type' => new CategoryTransType(),
                    'allow_add' => true,
                    'by_reference' => false
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
        return 'smt_cmsbundle_categorytype';
    }

}
