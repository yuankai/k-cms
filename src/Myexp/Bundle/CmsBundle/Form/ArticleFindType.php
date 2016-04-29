<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;

use Myexp\Bundle\AdminBundle\Form\ContentFindType;
use Myexp\Bundle\AdminBundle\Form\Type\ContentCategoryType;

class ArticleFindType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('content', ContentFindType::class, array(
                    'content_model' => 'article',
                ))
                ->add('category', ContentCategoryType::class, array(
                    'label' => 'content.category',
                    'content_model' => 'article',
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
        ;
    }
}
