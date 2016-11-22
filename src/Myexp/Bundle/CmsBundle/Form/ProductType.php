<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Myexp\Bundle\AdminBundle\Form\Type\ContentCategoryType;
use Myexp\Bundle\AdminBundle\Form\ContentType;

class ProductType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('category', ContentCategoryType::class, array(
                    'label' => 'content.category',
                    'content_model' => 'product',
                ))
                ->add('content', ContentType::class, array(
                    'content_model' => 'product'
                ))
                 ->add('featuredOrder', IntegerType::class, array(
                     'required' => false,
                    'label' => 'product.featured_order'
                ))
                ->add('stickOrder', IntegerType::class, array(
                    'required' => false,
                    'label' => 'product.stick_order'
                ))
                ->add('productPhotos', CollectionType::class, array(
                    'label' => 'product.photos',
                    'entry_type' => ProductPhotoType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'entry_options' => array(
                        'label' => false
                    )
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
