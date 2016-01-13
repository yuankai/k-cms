<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Myexp\Bundle\EditorBundle\Form\Type\EditorType;

class ProductType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', TextType::class, array(
                    'label' => 'product.title',
                    'required' => true
                ))
                ->add('content', EditorType::class, array(
                    'label' => 'product.title',
                    'required' => true
                ))
                ->add('category', EntityType::class, array(
                    'label' => 'product.category',
                    'class' => 'MyexpCmsBundle:Category',
                    'choice_label' => 'title',
                    'required' => true
                ))
                ->add('isActive', CheckboxType::class, array(
                    'label' => 'download.is_active',
                    'required' => false
                ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\CmsBundle\Entity\Product'
        ));
    }

}
