<?php

namespace Myexp\Bundle\FrontBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('_username', TextType::class , array(
            'label' => 'login.username'
        ));

        $builder->add('_password', PasswordType::class, array(
            'label' => 'login.password'
        ));

        $builder->add('_remember_me', CheckboxType::class, array(
            'required' => false,
            'label' => 'login.remember_me'
        ));
    }

    public function getName() {
        return 'myexp_bundle_frontbundle_login';
    }

}
