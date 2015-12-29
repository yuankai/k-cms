<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LinkType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', 'text', array(
                    'label' => false
                ))
                ->add('path', 'text', array(
                    'label' => 'link.path',
                    'attr' => array('size' => 80)
                ))
                ->add('filePhoto', 'file', array(
                    'label' => 'link.photo',
                    'required' => false
                ))
                ->add('sortOrder', 'integer', array(
                    'label' => 'link.order',
                    'required' => false,
                    'attr' => array('class' => 'number')
                ))
                ->add('isActive', 'checkbox', array(
                    'label' => 'link.is_active',
                    'required' => false
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\CmsBundle\Entity\Link'
        ));
    }

    public function getName() {
        return 'myexp_bundle_cmsbundle_link';
    }

}
