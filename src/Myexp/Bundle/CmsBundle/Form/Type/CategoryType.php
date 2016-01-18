<?php

namespace Myexp\Bundle\CmsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * 分类选择器字段类型
 *
 * @author Kevin
 */
class CategoryType extends AbstractType {
    
    protected $registry;

    public function __construct(RegistryInterface $registry) {
        $this->registry = $registry;
    }

    /**
     * 显示字段
     * 
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options) {
        
        $model = $options['model'];
        $em = $this->registry->getManager();
        
        $topCategories = array();
     
        $contentModel = $em->getRepository('MyexpCmsBundle:ContentModel')
                ->findOneBy(array('name'=>$model));
        
        if($contentModel){
            $topCategories = $em->getRepository('MyexpCmsBundle:Category')
                    ->findBy(array('contentModel'=>$contentModel));
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
            'model' => ''
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
