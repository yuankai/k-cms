<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DownloadType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', 'text', array(
                    'label' => 'download.title',
                    'required' => true
                ))
                ->add('file', 'file', array('label' => 'download.url', 'required' => false))
                ->add('category', 'entity', array(
                    'label' => 'download.category',
                    'class' => 'CmsBundle:Category',
                    'property' => 'trans.title',
                    'required' => true
                ))
                ->add('publishTime', 'date', array(
                    'label' => 'download.publish_time',
                    'required' => false,
                    'widget' => 'single_text'
                ))
                ->add('isActive', 'checkbox', array(
                    'label' => 'download.is_active',
                    'required' => false
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\CmsBundle\Entity\Download'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'smt_cmsbundle_download';
    }

}
