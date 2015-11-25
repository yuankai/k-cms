<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PhotoType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('album', 'entity', array(
                    'label' => 'photo.album',
                    'class' => 'SmtCmsBundle:Album',
                    'property' => 'trans.title',
                    'required' => true
                ))
                ->add('filePhoto', 'file', array(
                    'label' => 'photo.picurl',
                    'required' => false
                ))
                ->add('translations', 'collection', array(
                    'label' => 'photo.comment',
                    'type' => new PhotoTransType(),
                    'allow_add' => true,
                    'by_reference' => false
                ))
                ->add('isActive', 'checkbox', array(
                    'label' => 'photo.is_active',
                    'required' => false
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\CmsBundle\Entity\Photo'
        ));
    }

    public function getName() {
        return 'smt_cmsbundle_photo_type';
    }

}
