<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('content', ContentType::class, array(
                    'category_qbuilder' => null,
                    'status_qbuilder' => null
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

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\CmsBundle\Entity\Article',
        ));
    }

}
