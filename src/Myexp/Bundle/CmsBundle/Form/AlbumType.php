<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Myexp\Bundle\AdminBundle\Form\Type\ContentCategoryType;
use Myexp\Bundle\AdminBundle\Form\ContentType;

class AlbumType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('category', ContentCategoryType::class, array(
                    'label' => 'content.category',
                    'content_model' => 'album',
                ))
                ->add('content', ContentType::class, array(
                    'content_model' => 'page'
                ))
                ->add('featuredOrder', IntegerType::class, array(
                    'required' => false,
                    'label' => 'album.featured_order'
                ))
                ->add('stickOrder', IntegerType::class, array(
                    'required' => false,
                    'label' => 'album.stick_order'
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\CmsBundle\Entity\Album'
        ));
    }

}
