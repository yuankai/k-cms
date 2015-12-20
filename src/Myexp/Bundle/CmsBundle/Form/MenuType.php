<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MenuType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('parent', 'entity', array(
                    'label' => 'menu.parent',
                    'class' => 'CmsBundle:Menu',
                    'property' => 'trans.title',
                    'required' => false
                ))
                ->add('translations', 'collection', array(
                    'label' => 'menu.title',
                    'type' => new MenuTransType(),
                    'allow_add' => true,
                    'by_reference' => false
                ))
                ->add('path', 'text', array(
                    'label' => 'menu.path',
                    'attr' => array('size' => 80)
                ))
                ->add('isNav', 'checkbox', array(
                    'label' => 'menu.is_nav',
                    'required' => false
                ))
                ->add('sortOrder', 'integer', array(
                    'label' => 'menu.order',
                    'required' => false,
                    'attr' => array('class' => 'number')
                ))
                ->add('isIndex','checkbox',array(
                    'label'=>'menu.isIndex',
                    'required' => false))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\CmsBundle\Entity\Menu'
        ));
    }

    public function getName() {
        return 'smt_cmsbundle_menutype';
    }

}
