<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Myexp\Bundle\AdminBundle\Form\Type\ContentCategoryType;
use Myexp\Bundle\AdminBundle\Form\ContentType;
use Myexp\Bundle\FinderBundle\Form\Type\FinderType;

class ArticleType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('category', ContentCategoryType::class, array(
                    'label' => 'content.category',
                    'content_model' => 'article',
                ))
                ->add('content', ContentType::class, array(
                    'content_model' => 'article'
                ))
                ->add('imageUrl', FinderType::class, array(
                    'label' => 'article.image_url',
                    'required' => false,
                    'class' => 'article-image-container'
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
                 ->add('featuredOrder', IntegerType::class, array(
                    'required' => false,
                    'label' => 'article.featured_order'
                ))
                ->add('stickOrder', IntegerType::class, array(
                    'required' => false,
                    'label' => 'article.stick_order'
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\CmsBundle\Entity\Article',
        ));
    }

}
