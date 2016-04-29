<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Myexp\Bundle\AdminBundle\Form\Type\ContentCategoryType;
use Myexp\Bundle\AdminBundle\Form\ContentType;

class DownloadType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('category', ContentCategoryType::class, array(
                    'label' => 'content.category',
                    'content_model' => 'download',
                ))
                 ->add('content', ContentType::class, array(
                    'content_model' => 'download'
                ))
                ->add('publishTime', DateTimeType::class, array(
                    'label' => 'download.publish_time',
                    'required' => false,
                    'widget' => 'single_text'
                ))
                 ->add('featuredOrder', IntegerType::class, array(
                     'required' => false,
                    'label' => 'download.featured_order'
                ))
                ->add('stickOrder', IntegerType::class, array(
                    'required' => false,
                    'label' => 'download.stick_order'
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\CmsBundle\Entity\Download'
        ));
    }

}
