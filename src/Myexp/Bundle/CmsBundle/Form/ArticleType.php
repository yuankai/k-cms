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
use Myexp\Bundle\FinderBundle\Form\Type\FinderType;
use Myexp\Bundle\CmsBundle\Form\Type\CategoryType;

class ArticleType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('category', CategoryType::class, array(
                    'label' => 'article.category',
                    'model'=>'article'
                ))
                ->add('title', TextType::class, array(
                    'label' => 'article.title',
                    'attr' => array('size' => 80)
                ))
                ->add('content', EditorType::class, array(
                    'label' => 'article.content',
                    'required' => false
                ))
                ->add('filePhoto', FinderType::class, array(
                    'label' => 'article.pic', 
                    'required' => false
                ))
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

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\CmsBundle\Entity\Article'
        ));
    }

}
