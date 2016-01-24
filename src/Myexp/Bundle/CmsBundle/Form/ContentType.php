<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\Common\Persistence\ObjectManager;

use Myexp\Bundle\CmsBundle\Form\Type\CategoryType;
use Myexp\Bundle\EditorBundle\Form\Type\EditorType;
use Myexp\Bundle\CmsBundle\Form\Type\EntityIdType;
use Myexp\Bundle\CmsBundle\EventListener\UrlAliasSubscriber;

class ContentType extends AbstractType {

    /**
     *
     * @var type 
     */
    private $manager;

    /**
     *
     * @var type 
     */
    private $session;

    /**
     * 
     * @param ObjectManager $manager
     */
    public function __construct(ObjectManager $manager, Session $session) {
        $this->manager = $manager;
        $this->session = $session;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        //获得模型实体
        $contentModelName = $options['model_name'];
        $contentModelEntity = $this->manager
                ->getRepository('MyexpCmsBundle:ContentModel')
                ->findOneBy(array('name' => $contentModelName));

        //内容类型不存在
        if (null === $contentModelEntity) {
            throw new \LogicException(sprintf(
                    'Content model %s does not exist!', $contentModelName
            ));
        }
        
        //url别名监听器
        $builder->addEventSubscriber(new UrlAliasSubscriber($this->manager, $contentModelEntity));
        
        //当前网站
        $website = $this->session->get('currentWebsite');

        //只有可分类模型才添加分类字段
        if ($contentModelEntity->getIsClassable()) {
            $builder->add('category', CategoryType::class, array(
                'label' => 'content.category',
                'content_model' => $contentModelEntity,
                'website' => $website
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
                ->add('urlAlias', EntityIdType::class, array(
                    'class' => 'MyexpCmsBundle:UrlAlias',
                    'required' => false
                ))
                ->add('urlAliasUrl', TextType::class, array(
                    'label' => 'content.url_alias',
                    'invalid_message' => 'Url alias existed!',
                    'mapped' => false,
                    'required' => false
                ))
                ->add('contentStatus', EntityType::class, array(
                    'label' => 'content.status',
                    'class' => 'MyexpCmsBundle:ContentStatus',
                    'choice_label' => 'title'
                ))
                ->add('website', EntityIdType::class, array(
                    'class' => 'MyexpCmsBundle:Website'
                ))
                ->add('contentModel', EntityIdType::class, array(
                    'class' => 'MyexpCmsBundle:ContentModel'
                ))
        ;

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

        //设置表单的内容类型
        $builder->get('contentModel')->setData($contentModelEntity);

        //设置当前网站
        $builder->get('website')->setData($website);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\CmsBundle\Entity\Content',
            'label' => false,
            'model_name' => ''
        ));
    }

}
