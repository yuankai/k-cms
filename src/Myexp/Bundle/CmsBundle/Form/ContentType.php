<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Myexp\Bundle\CmsBundle\Form\Type\CategoryType;
use Myexp\Bundle\EditorBundle\Form\Type\EditorType;
use Myexp\Bundle\CmsBundle\Form\Type\EntityIdType;

class ContentType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        //显示分类
        $categoryQueryBuilder = $options['category_qbuilder'];
        if ($categoryQueryBuilder) {
            $builder->add('category', CategoryType::class, array(
                'label' => 'content.category',
                'query_builder' => $categoryQueryBuilder
            ));
        }

        //常规字段
        $builder
                ->add('title', TextType::class, array(
                    'label' => 'content.title',
                    'attr' => array('size' => 80)
                ))
                ->add('description', EditorType::class, array(
                    'label' => 'content.description',
                    'required' => false
                ))
                ->add('keywords', TextType::class, array(
                    'label' => 'content.keywords',
                    'attr' => array('size' => 80),
                    'required' => false
                ))
                ->add('urlAlias', TextType::class, array(
                    'label' => 'content.url_alias',
                    'required' => false
                ))
                ->add('website', EntityIdType::class, array(
                    'class' => 'MyexpCmsBundle:Website'
                ))
                ->add('contentModel', EntityIdType::class, array(
                    'class' => 'MyexpCmsBundle:ContentModel'
        ));

        //内容状态
        $statusQueryBuilder = $options['status_qbuilder'];
        if ($categoryQueryBuilder) {
            $builder->add('contentStatus', EntityType::class, array(
                'label' => 'content.status',
                'class' => 'MyexpCmsBundle:ContentStatus',
                'choice_label' => 'title',
                'query_builder' => $statusQueryBuilder
            ));
        }
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\CmsBundle\Entity\Content',
            'label' => false,
            'category_qbuilder' => null,
            'status_qbuilder' => null
        ));
    }

}
