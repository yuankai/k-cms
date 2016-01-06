<?php

namespace Myexp\Bundle\EditorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * 富文本编辑器字段类型
 *
 * @author Kevin
 */
class EditorType extends AbstractType {

    /**
     * 显示字段
     * 
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options) {
        $view->vars['options'] = $options['options'];
        parent::buildView($view, $form, $options);
    }

    /**
     * 默认选项
     * 
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'options' => array()
        ));
    }

    /**
     *  上级类型
     * 
     * @return string
     */
    public function getParent() {
        return TextareaType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'editor';
    }

}
