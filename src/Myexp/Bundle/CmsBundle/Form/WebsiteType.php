<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WebsiteType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title')
                ->add('httpUrl')
                ->add('httpsUrl')
                ->add('icpNum')
                ->add('address')
                ->add('zipCode')
                ->add('email')
                ->add('tel')
                ->add('fax')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\CmsBundle\Entity\Website'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'myexp_bundle_cmsbundle_website';
    }

}
