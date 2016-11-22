<?php

namespace Myexp\Bundle\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class UserEditType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('email', 'email', array('label' => 'user.email'));

        // add group form
        $builder->add('roles', 'entity', array(
            'label' => 'user.roles',
            'class' => 'MyexpAdminBundle:Role',
            'property' => 'name',
            'expanded' => true,
            'multiple' => true,
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('r');
            }
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {

        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\AdminBundle\Entity\User'
        ));
    }

    public function getName() {
        return 'myexp_bundle_AdminBundle_user_edit';
    }

}
