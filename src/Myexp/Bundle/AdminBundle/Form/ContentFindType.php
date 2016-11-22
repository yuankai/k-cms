<?php

namespace Myexp\Bundle\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\Common\Persistence\ObjectManager;
use Myexp\Bundle\AdminBundle\Form\Type\EntityIdType;

class ContentFindType extends AbstractType {

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
     * @param Session $session
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
        $contentModelName = $options['content_model'];
        $contentModelEntity = $this->manager
                ->getRepository('MyexpAdminBundle:ContentModel')
                ->findOneBy(array('name' => $contentModelName));

        //内容类型不存在
        if (null === $contentModelEntity) {
            throw new \LogicException(sprintf(
                    'Content model %s does not exist!', $contentModelName
            ));
        }

        //当前网站
        $website = $this->session->get('currentWebsite');

        //常规字段
        $builder
                ->add('title', TextType::class, array(
                    'label' => 'content.title',
                    'required' => false
                ))
                ->add('keywords', TextType::class, array(
                    'label' => 'content.keywords',
                    'required' => false
                ))
                ->add('website', EntityIdType::class, array(
                    'class' => 'MyexpAdminBundle:Website'
                ))
                ->add('contentModel', EntityIdType::class, array(
                    'class' => 'MyexpAdminBundle:ContentModel'
                ))
        ;

        //内容状态
        $contentStatuses = $this->manager
                ->getRepository('MyexpAdminBundle:ContentStatus')
                ->getByContentModel($contentModelEntity);

        $builder->add('contentStatus', EntityType::class, array(
            'label' => 'content.status',
            'class' => 'MyexpAdminBundle:ContentStatus',
            'choice_label' => 'title',
            'choices' => $contentStatuses,
            'required' => false
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
            'label' => false,
            'content_model' => ''
        ));
    }

}
