<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Myexp\Bundle\EditorBundle\Form\Type\EditorType;

class ArticleType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', TextType::class, array(
                    'label' => 'article.title',
                    'attr' => array('size' => 80)
                ))
                ->add('content', EditorType::class, array(
                    'label' => 'article.content',
                    'required' => false
                ))
                ->add('category', EntityType::class, array(
                    'label' => 'article.category',
                    'class' => 'MyexpCmsBundle:Category',
                    'choice_label' => 'title',
                    'required' => true
                ))
                ->add('filePhoto', FileType::class, array('label' => 'article.pic', 'required' => false))
                ->add('author', TextType::class, array(
                    'label' => 'article.author',
                    'required' => false
                ))
                ->add('source', TextType::class, array(
                    'label' => 'article.source',
                    'required' => false
                ))
                ->add('publishTime', DateTimeType::class, array(
                    'label' => 'article.publish_time',
                    'required' => false,
                    'widget' => 'single_text'
                ))
                ->add('isActive', CheckboxType::class, array(
                    'label' => 'article.is_active',
                    'required' => false
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\CmsBundle\Entity\Article'
        ));
    }

}
