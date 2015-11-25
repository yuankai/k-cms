<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageTransType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', 'text', array(
                    'label' => 'page.title'
                ))
                ->add('content', 'textarea', array(
                    'label' => 'page.content',
                    'required' => false
                ))
                ->add('lang', 'hidden')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\CmsBundle\Entity\PageTranslation'
        ));
    }

    public function getName() {
        return 'smt_cmsbundle_page_translation_type';
    }

}
