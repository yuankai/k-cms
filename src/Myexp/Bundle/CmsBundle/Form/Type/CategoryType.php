<?php

namespace Myexp\Bundle\CmsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\Common\Persistence\ObjectManager;

use Myexp\Bundle\CmsBundle\Form\DataTransformer\EntityToIdTransformer;

/**
 * 分类选择器字段类型
 *
 * @author Kevin
 */
class CategoryType extends AbstractType {
    
    private $manager;
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
     * 构建form
     * 
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->addModelTransformer(new EntityToIdTransformer($this->manager, 'MyexpCmsBundle:Category'));
        parent::buildForm($builder, $options);
    }

    /**
     * 显示字段
     * 
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options) {
        
        $model = $options['content_model'];
        $website = $this->session->get('currentWebsite');
        
        $topCategories = array();
     
        $contentModel = $this->manager
                ->getRepository('MyexpCmsBundle:ContentModel')
                ->findOneBy(array(
                    'name'=>$model
                ));
        
        if($contentModel){
            $topCategories = $this->manager
                    ->getRepository('MyexpCmsBundle:Category')
                    ->findBy(array(
                        'contentModel'=>$contentModel,
                        'website'=>$website
                    ));
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
            'content_model' => ''
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
        return 'category';
    }

}
