<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Myexp\Bundle\EditorBundle\Form\Type\EditorType;

class PageType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', TextType::class, array(
                    'label' => 'page.title'
                ))
                ->add('content', EditorType::class, array(
                    'label' => 'page.content',
                    'required' => false
                ))
                ->add('name', TextType::class, array('label' => 'page.name'))
                ->add('filePhoto', FileType::class, array('label' => 'page.path', 'required' => false))
                ->add('sortOrder', IntegerType::class, array(
                    'label' => 'category.order',
                    'required' => false,
                    'attr' => array('class' => 'number')
                ))
                 ->add('save', SubmitType::class, array(
                    'label'=> 'common.submit'
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\CmsBundle\Entity\Page'
        ));
    }
}
