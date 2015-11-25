<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SliderPhotoType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                ->add('path', 'text', array(
                    'label' => 'slider.photo_path',
                    'attr' => array('class' => 'slider_photo_path')
                ))
                ->add('title', 'text', array(
                    'label' => 'slider.photo_title',
                    'required' => false
                ))
                ->add('link', 'text', array(
                    'label' => 'slider.photo_link',
                    'required' => false
                ))
                ->add('lang', 'lang', array(
                    'label' => 'slider.photo_lang',
                    'required' => false
                ))
                ->add('sortOrder', 'integer', array(
                    'label' => 'slider.photo_order',
                    'required' => false,
                    'attr' => array('class' => 'number')
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\CmsBundle\Entity\SliderPhoto'
        ));
    }

    public function getName() {
        return 'smt_cmsbundle_sliderphototype';
    }

}
