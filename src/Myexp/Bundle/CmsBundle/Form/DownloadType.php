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

class DownloadType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', TextType::class, array(
                    'label' => 'download.title',
                    'required' => true
                ))
                ->add('file', FileType::class, array(
                    'label' => 'download.url', 
                    'required' => false
                 ))
                ->add('category', EntityType::class, array(
                    'label' => 'download.category',
                    'class' => 'MyexpCmsBundle:Category',
                    'choice_label' => 'title',
                    'required' => true
                ))
                ->add('publishTime', DateTimeType::class, array(
                    'label' => 'download.publish_time',
                    'required' => false,
                    'widget' => 'single_text'
                ))
                ->add('isActive', CheckboxType::class, array(
                    'label' => 'download.is_active',
                    'required' => false
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
