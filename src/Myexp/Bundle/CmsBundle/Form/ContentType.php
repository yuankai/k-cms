<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\Common\Persistence\ObjectManager;
use Myexp\Bundle\CmsBundle\Form\Type\CategoryType;
use Myexp\Bundle\EditorBundle\Form\Type\EditorType;
use Myexp\Bundle\CmsBundle\Form\Type\EntityIdType;
use Myexp\Bundle\CmsBundle\Form\DataTransformer\UrlAliasTransformer;

class ContentType extends AbstractType {

    /**
     *
     * @var type 
     */
    protected $manager;

    /**
     * 
     * @param ObjectManager $manager
     */
    public function __construct(ObjectManager $manager) {
        $this->manager = $manager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        //显示分类
        $contentModel = $options['content_model'];

        $contentModelEntity = $this->manager
                ->getRepository('MyexpCmsBundle:ContentModel')
                ->findOneBy(array(
            'name' => $contentModel
        ));

        //只有可分类模型才添加分类字段
        if ($contentModelEntity->getIsClassable()) {
            $builder->add('category', CategoryType::class, array(
                'label' => 'content.category',
                'content_model' => $contentModel
            ));
        }

        //常规字段
        $builder
                ->add('title', TextType::class, array(
                    'label' => 'content.title'
                ))
                ->add('description', EditorType::class, array(
                    'label' => 'content.description',
                    'required' => false
                ))
                ->add('keywords', TextType::class, array(
                    'label' => 'content.keywords',
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

        //添加url别名转换器
        $builder->get('urlAlias')->addModelTransformer(new UrlAliasTransformer(
                $this->manager, $contentModelEntity
        ));

        //内容状态
        $contentStatuses = $this->manager
                ->getRepository('MyexpCmsBundle:ContentStatus')
                ->getByContentModel($contentModelEntity);

        $builder->add('contentStatus', EntityType::class, array(
            'label' => 'content.status',
            'class' => 'MyexpCmsBundle:ContentStatus',
            'choice_label' => 'title',
            'choices' => $contentStatuses
        ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\CmsBundle\Entity\Content',
            'label' => false,
            'content_model' => ''
        ));
    }

}
