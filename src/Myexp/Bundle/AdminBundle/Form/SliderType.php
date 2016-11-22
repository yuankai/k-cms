<?php

namespace Myexp\Bundle\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SliderType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', TextType::class, array(
                    'label' => 'slider.name'
                ))
                ->add('title', TextType::class, array(
                    'label' => 'slider.title'
                ))
                ->add('width', IntegerType::class, array(
                    'label' => false,
                    'attr' => array(
                        'class' => 'number',
                        'placeholder' => 'slider.width'
                    )
                ))
                ->add('height', IntegerType::class, array(
                    'label' => false,
                    'attr' => array(
                        'class' => 'number',
                        'placeholder' => 'slider.height'
                    )
                ))
                ->add('isActive', CheckboxType::class, array(
                    'label' => 'slider.is_active',
                    'required' => false
                ))
                ->add('sliderPhotos', CollectionType::class, array(
                    'label' => 'slider.photos',
                    'entry_type' => SliderPhotoType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'attr' => array('class' => 'slider_photos'),
                    'entry_options' => array(
                        'label' => false,
                        'attr' => array('class' => 'slider_photo')
                    )
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\AdminBundle\Entity\Slider'
        ));
    }

}
