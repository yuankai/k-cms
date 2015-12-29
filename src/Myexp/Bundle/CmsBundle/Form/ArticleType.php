<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', 'text', array(
                    'label' => 'article.title',
                    'attr' => array('size' => 80)
                ))
                ->add('content', 'textarea', array(
                    'label' => 'article.content',
                    'required' => false
                ))
                ->add('category', 'entity', array(
                    'label' => 'article.category',
                    'class' => 'CmsBundle:Category',
                    'property' => 'trans.title',
                    'required' => true
                ))
                ->add('filePhoto', 'file', array('label' => 'article.pic', 'required' => false))
                ->add('author', 'text', array(
                    'label' => 'article.author',
                    'required' => false
                ))
                ->add('source', 'text', array(
                    'label' => 'article.source',
                    'required' => false
                ))
                ->add('publishTime', 'date', array(
                    'label' => 'article.publish_time',
                    'required' => false,
                    'widget' => 'single_text'
                ))
                ->add('isActive', 'checkbox', array(
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

    public function getName() {
        return 'myexp_bundle_cmsbundle_article';
    }

}
