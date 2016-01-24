<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Myexp\Bundle\CmsBundle\Form\Type\EntityIdType;

class MenuType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', TextType::class, array(
                    'label' => 'menu.name',
                ))
                ->add('title', TextType::class, array(
                    'label' => 'menu.title'
                ))
                ->add('website', EntityIdType::class, array(
                    'class' => 'MyexpCmsBundle:Website'
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\CmsBundle\Entity\Menu'
        ));
    }

}
