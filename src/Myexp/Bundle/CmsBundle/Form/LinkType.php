<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LinkType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', TextType::class, array(
                    'label' => false
                ))
                ->add('path', TextType::class, array(
                    'label' => 'link.path',
                    'attr' => array('size' => 80)
                ))
                ->add('filePhoto', FileType::class, array(
                    'label' => 'link.photo',
                    'required' => false
                ))
                ->add('sortOrder', IntegerType::class, array(
                    'label' => 'link.order',
                    'required' => false,
                    'attr' => array('class' => 'number')
                ))
                ->add('isActive', CheckboxType::class, array(
                    'label' => 'link.is_active',
                    'required' => false
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\CmsBundle\Entity\Link'
        ));
    }

}
