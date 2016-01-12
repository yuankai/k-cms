<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', TextType::class, array(
                    'label' => 'category.title',
                    'attr' => array('size' => 80)
                ))
                ->add('keywords', TextType::class, array(
                    'label' => 'category.keywords',
                    'required' => false,
                    'attr' => array('size' => 80)
                ))
                ->add('parent', EntityType::class, array(
                    'label' => 'category.parent',
                    'class' => 'MyexpCmsBundle:Category',
                    'choice_label' => 'title',
                    'required' => false
                ))
                ->add('sortOrder', IntegerType::class, array(
                    'label' => 'category.order',
                    'required' => false,
                    'attr' => array('class' => 'number')
                ))
                ->add('isActive', CheckboxType::class, array(
                    'label' => 'category.is_active',
                    'required' => false
                ))
                ->add('website', EntityType::class, array(
                    'class'=>'MyexpCmsBundle:Website',
                    'label'=>false,
                    'required'=>true
                ))
                ->add('contentModel', EntityType::class, array(
                    'class'=>'MyexpCmsBundle:ContentModel',
                    'label'=>false,
                    'required'=>true
                ))
        ;
    }

    /**
     * 默认配置
     * 
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\CmsBundle\Entity\Category',
            'csrf_protection' => false
        ));
    }

}
