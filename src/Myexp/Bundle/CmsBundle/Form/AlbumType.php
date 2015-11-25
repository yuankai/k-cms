<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AlbumType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', 'text', array(
                    'label' => 'album.name',
                    'attr' => array('size' => 80)
                ))
                ->add('translations', 'collection', array(
                    'label' => 'album.title',
                    'type' => new AlbumTransType(),
                    'allow_add' => true,
                    'by_reference' => false
                ))
                ->add('sortOrder', 'integer', array(
                    'label' => 'album.order',
                    'required' => false,
                    'attr' => array('class' => 'number')
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\CmsBundle\Entity\Album'
        ));
    }

    public function getName() {
        return 'smt_cmsbundle_albumtype';
    }

}
