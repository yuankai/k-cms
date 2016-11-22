<?php

namespace Myexp\Bundle\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\Common\Persistence\ObjectManager;

use Myexp\Bundle\AdminBundle\Form\DataTransformer\EntityToIdTransformer;

/**
 * 内容分类选择器字段类型
 *
 * @author Kevin
 */
class ContentCategoryType extends AbstractType {

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
     * 内容类型
     * 
     * @var type 
     */
    private $contentModel;
    
    /**
     *
     * 当前网站
     * 
     * @var type 
     */
    private $website;

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
     * 构建form
     * 
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        //获得模型实体
        $contentModelName = $options['content_model'];
        $this->contentModel = $this->manager
                ->getRepository('MyexpAdminBundle:ContentModel')
                ->findOneBy(array('name' => $contentModelName));
        
        //当前网站
        $this->website = $this->session->get('currentWebsite');
        
        $builder->addModelTransformer(new EntityToIdTransformer($this->manager, 'MyexpAdminBundle:Category'));
    }

    /**
     * 显示字段
     * 
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options) {

        $topCategories = array();

        if ($this->contentModel) {
            $topCategories = $this
                    ->manager
                    ->getRepository('MyexpAdminBundle:Category')
                    ->findBy(array(
                        'contentModel' => $this->contentModel,
                        'website' => $this->website,
                        'parent' => null
                    ))
            ;
        }
        
        $view->vars['categories'] = $topCategories;

        parent::buildView($view, $form, $options);
    }

    /**
     * 默认选项
     * 
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'content_model' => null
        ));
    }

    /**
     *  上级类型
     * 
     * @return string
     */
    public function getParent() {
        return TextType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'content_category';
    }

}
