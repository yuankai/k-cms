<?php

namespace Myexp\Bundle\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Myexp\Bundle\AdminBundle\Form\Type\EntityIdType;

class MenuItemType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', TextType::class, array(
                    'label' => 'menu.title'
                ))
                ->add('url', TextType::class, array(
                    'label' => 'menu.item.url'
                ))
                ->add('target', TextType::class, array(
                    'label' => 'menu.item.target',
                    'required' => false
                ))
                ->add('style', TextType::class, array(
                    'label' => 'menu.item.style',
                    'required' => false
                ))
                ->add('isActive', CheckboxType::class, array(
                    'label' => 'menu.item.is_active',
                    'required' => false
                ))
                ->add('parent', EntityIdType::class, array(
                    'class' => 'MyexpAdminBundle:MenuItem',
                    'required' => true
                ))
                ->add('menu', EntityIdType::class, array(
                    'class' => 'MyexpAdminBundle:Menu',
                    'required' => true
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\AdminBundle\Entity\MenuItem'
        ));
    }

}
