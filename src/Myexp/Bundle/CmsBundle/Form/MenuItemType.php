<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Myexp\Bundle\CmsBundle\Form\Type\EntityIdType;

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
                ->add('parent', EntityIdType::class, array(
                    'class' => 'MyexpCmsBundle:MenuItem',
                    'required' => true
                ))
                ->add('menu', EntityIdType::class, array(
                    'class' => 'MyexpCmsBundle:Menu',
                    'required' => true
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\CmsBundle\Entity\MenuItem'
        ));
    }

}
