<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('translations', 'collection', array(
                    'label' => false,
                    'type' => new ArticleTransType(),
                    'allow_add' => true,
                    'by_reference' => false
                ))
                ->add('category', 'entity', array(
                    'label' => 'article.category',
                    'class' => 'SmtCmsBundle:Category',
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
        return 'smt_cmsbundle_article_type';
    }

}
