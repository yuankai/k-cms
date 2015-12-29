<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ChangePasswordType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('currentPassword', 'password', array(
            'label' => 'user.password.current'
        ));

        $builder->add('newPassword', 'repeated', array(
            'first_name' => 'newPassword',
            'second_name' => 'confirm',
            'type' => 'password',
            'first_options' => array('label' => 'user.password.new'),
            'second_options' => array('label' => 'user.password.confirm')
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\CmsBundle\Form\ChangePassword',
        ));
    }

    public function getName() {
        return 'myexp_bundle_cmsbundle_change_password';
    }

}