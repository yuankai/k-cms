<?php

namespace Myexp\Bundle\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * 用户表单类型
 */
class UserType extends AbstractType {

    /**
     * 
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                ->add('username', TextType::class, array('label' => 'register.username'))
                ->add('email', EmailType::class, array('label' => 'register.email'))
                ->add('password', RepeatedType::class, array(
                    'first_name' => 'password',
                    'second_name' => 'confirm',
//                    'type' => 'password',
                    'first_options' => array('label' => 'register.password'),
                    'second_options' => array('label' => 'register.password_confirm')
                ))
                ->add('roles', EntityType::class, array(
                    'label' => 'user.role',
                    'class' => 'MyexpAdminBundle:Role',
                    'choice_label' => 'name',
                    'expanded' => true,
                    'multiple' => true
                ))
                ->add('save', SubmitType::class, array('label'=>'common.submit'))
        ;
    }

    /**
     * 
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\AdminBundle\Entity\User'
        ));
    }

    /**
     * 
     * @return string
     */
    public function getName() {
        return 'myexp_bundle_AdminBundle_user';
    }

}
