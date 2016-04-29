<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Myexp\Bundle\FinderBundle\Form\Type\FinderType;

class ProductPhotoType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                ->add('url', FinderType::class, array(
                    'label' => false,
                    'multiple'=>true
                ))
                ->add('title', TextType::class, array(
                    'label' => 'product.photo.title',
                    'required' => false
                ))
                ->add('sequenceId', IntegerType::class, array(
                    'label' => 'product.photo.sequence_id',
                    'required' => false,
                    'attr' => array('class' => 'number')
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\CmsBundle\Entity\ProductPhoto'
        ));
    }

}
