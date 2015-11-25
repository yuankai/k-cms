<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('username', 'text', array('label' => 'register.username'));
        $builder->add('email', 'email', array('label' => 'register.email'));
        $builder->add('password', 'repeated', array(
            'first_name' => 'password',
            'second_name' => 'confirm',
            'type' => 'password',
            'first_options' => array('label' => 'register.password'),
            'second_options' => array('label' => 'register.password_confirm')
        ));
        $builder->add('groups', 'entity', array(
            'label' => 'user.group',
            'class' => 'SmtCmsBundle:Group',
            'property' => 'name',
            'expanded' => true,
            'multiple' => true
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {

        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\CmsBundle\Entity\User'
        ));
    }

    public function getName() {
        return 'smt_cmsbundle_user_type';
    }

}
