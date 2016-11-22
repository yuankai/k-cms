<?php

namespace Myexp\Bundle\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Myexp\Bundle\AdminBundle\Form\Type\EntityIdType;

class NodeType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', TextType::class, array(
                    'label' => 'node.title',
                    'attr' => array('size' => 80)
                ))
                ->add('path', TextType::class, array(
                    'label' => 'node.path',
                    'required' => false
                ))
                ->add('sequenceId', IntegerType::class, array(
                    'label' => 'node.sequence_id',
                    'required' => false,
                    'attr' => array('class' => 'number')
                ))
                ->add('isActive', CheckboxType::class, array(
                    'label' => 'node.is_active',
                    'required' => false
                ))
                ->add('parent', EntityIdType::class, array(
                    'class' => 'MyexpAdminBundle:Node',
                    'required' => false
                ))
                ->add('website', EntityIdType::class, array(
                    'class' => 'MyexpAdminBundle:Website',
                    'required' => true
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\AdminBundle\Entity\Node'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'myexp_bundle_AdminBundle_node';
    }

}
