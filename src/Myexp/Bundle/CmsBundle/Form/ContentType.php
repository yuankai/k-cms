<?php

namespace Myexp\Bundle\CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\Common\Persistence\ObjectManager;
use Myexp\Bundle\CmsBundle\Form\Type\CategoryType;
use Myexp\Bundle\EditorBundle\Form\Type\EditorType;
use Myexp\Bundle\CmsBundle\Form\Type\EntityIdType;

use Myexp\Bundle\CmsBundle\EventListener\ContentFormSubscriber;

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

        //添加监听器
        $builder->addEventSubscriber(new ContentFormSubscriber($this->manager, $this->session));

        //常规字段
        $builder
                ->add('category', CategoryType::class, array(
                    'label' => 'content.category',
                    'content_model' => null
                ))
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
                ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\CmsBundle\Entity\Content',
            'label' => false
        ));
    }

}
