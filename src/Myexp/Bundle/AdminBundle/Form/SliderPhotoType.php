<?php

namespace Myexp\Bundle\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Myexp\Bundle\FinderBundle\Form\Type\FinderType;

class SliderPhotoType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                ->add('url', FinderType::class, array(
                    'label' => false,
                    'multiple'=>true
                ))
                ->add('title', TextType::class, array(
                    'label' => 'slider.photo.title',
                    'required' => false
                ))
                ->add('description', TextareaType::class, array(
                    'label' => 'slider.photo.description',
                    'required' => false
                ))
                ->add('link', TextType::class, array(
                    'label' => 'slider.photo.link',
                    'required' => false
                ))
                ->add('sequenceId', IntegerType::class, array(
                    'label' => 'slider.photo.sequence_id',
                    'required' => false,
                    'attr' => array('class' => 'number')
                ))
                ->add('isActive', CheckboxType::class, array(
                    'label' => 'slider.photo.is_active',
                    'required' => false
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\AdminBundle\Entity\SliderPhoto'
        ));
    }

}
