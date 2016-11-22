<?php

namespace Myexp\Bundle\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Myexp\Bundle\FinderBundle\Form\Type\FinderType;
use Myexp\Bundle\AdminBundle\Form\Type\EntityIdType;

class LinkType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', TextType::class, array(
                     'label' => 'link.title',
                ))
                ->add('url', TextType::class, array(
                    'label' => 'link.url',
                    'required' => false,
                ))
                ->add('logoUrl', FinderType::class, array(
                    'label' => 'link.logo_url',
                    'required' => false,
                    'class'=>'logo-container'
                ))
                ->add('sequenceId', IntegerType::class, array(
                    'label' => 'link.sequence_id',
                    'required' => false,
                    'attr' => array('class' => 'number')
                ))
                ->add('isActive', CheckboxType::class, array(
                    'label' => 'link.is_active',
                    'required' => false
                ))
                 ->add('website', EntityIdType::class, array(
                    'class' => 'MyexpAdminBundle:Website',
                    'required' => true
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\AdminBundle\Entity\Link'
        ));
    }

}
