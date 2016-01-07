<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
                ->add('title', TextType::class, array(
                    'label' => 'website.title'
                ))
                ->add('httpUrl', TextType::class, array(
                    'label' => 'website.http_url'
                ))
                ->add('httpsUrl', TextType::class, array(
                    'label' => 'website.https_url'
                ))
                ->add('icpNum', TextType::class, array(
                    'label' => 'website.icp_num'
                ))
                ->add('address', TextType::class, array(
                    'label' => 'website.address'
                ))
                ->add('zipCode', TextType::class, array(
                    'label' => 'website.zip_code'
                ))
                ->add('email', TextType::class, array(
                    'label' => 'website.email'
                ))
                ->add('tel', TextType::class, array(
                    'label' => 'website.tel'
                ))
                ->add('fax', TextType::class, array(
                    'label' => 'website.fax'
                ))
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
