<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', 'text', array(
                    'label' => 'page.title'
                ))
                ->add('content', 'textarea', array(
                    'label' => 'page.content',
                    'required' => false
                ))
                ->add('name', 'text', array('label' => 'page.name'))
                ->add('filePhoto', 'file', array('label' => 'page.path', 'required' => false))
                ->add('translations', 'collection', array(
                    'label' => false,
                    'type' => new PageTransType(),
                    'by_reference' => false,
                    'allow_add' => true
                ))
                ->add('category', 'entity', array(
                    'label' => 'article.category',
                    'class' => 'CmsBundle:Category',
                    'property' => 'trans.title',
                    'required' => false
                ))
                ->add('sortOrder', 'integer', array(
                    'label' => 'category.order',
                    'required' => false,
                    'attr' => array('class' => 'number')
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\CmsBundle\Entity\Page'
        ));
    }

    public function getName() {
        return 'myexp_bundle_cmsbundle_page';
    }

}
