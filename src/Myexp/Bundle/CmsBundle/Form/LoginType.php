<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('_username', 'text', array(
            'label' => 'login.username'
        ));

        $builder->add('_password', 'password', array(
            'label' => 'login.password'
        ));

        $builder->add('_remember_me', 'checkbox', array(
            'required' => false,
            'label' => 'login.remember_me'
        ));
    }

    public function getName() {
        return NULL;
    }

}
