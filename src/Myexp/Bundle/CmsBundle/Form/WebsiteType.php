<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WebsiteType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', TextType::class, array(
                    'label' => 'website.name'
                ))
                ->add('title', TextType::class, array(
                    'label' => 'website.title',
                    'required'=>false
                ))
                ->add('httpUrl', TextType::class, array(
                    'label' => 'website.http_url',
                    'required'=>false
                ))
                ->add('httpsUrl', TextType::class, array(
                    'label' => 'website.https_url',
                    'required'=>false
                ))
                ->add('icpNum', TextType::class, array(
                    'label' => 'website.icp_num',
                    'required'=>false
                ))
                ->add('address', TextType::class, array(
                    'label' => 'website.address',
                    'required'=>false
                ))
                ->add('zipCode', TextType::class, array(
                    'label' => 'website.zip_code',
                    'required'=>false
                ))
                ->add('email', TextType::class, array(
                    'label' => 'website.email',
                    'required'=>false
                ))
                ->add('tel', TextType::class, array(
                    'label' => 'website.tel',
                    'required'=>false
                ))
                ->add('fax', TextType::class, array(
                    'label' => 'website.fax',
                    'required'=>false
                ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\CmsBundle\Entity\Website'
        ));
    }

}
