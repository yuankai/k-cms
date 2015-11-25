<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SliderType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', 'text', array(
                    'label' => 'slider.name'
                ))
                ->add('title', 'text', array(
                    'label' => 'slider.title'
                ))
                ->add('width', 'integer', array(
                    'label' => 'slider.width',
                    'attr' => array('class' => 'number')
                ))
                ->add('height', 'integer', array(
                    'label' => 'slider.height',
                    'attr' => array('class' => 'number')
                ))
                ->add('sliderPhotos', 'collection', array(
                    'label' => 'slider.photos',
                    'type' => new SliderPhotoType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'attr' => array('class' => 'slider_photos'),
                    'options' => array(
                        'label' => false,
                        'attr' => array('class' => 'slider_photo')
                    )
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\CmsBundle\Entity\Slider'
        ));
    }

    public function getName() {
        return 'smt_cmsbundle_slidertype';
    }

}
