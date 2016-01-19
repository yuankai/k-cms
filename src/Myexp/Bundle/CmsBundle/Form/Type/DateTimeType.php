<?php

namespace Myexp\Bundle\CmsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * 日期时间选择器字段类型
 *
 * @author Kevin
 */
class DateTimeType extends AbstractType {

    /**
     * @var MomentFormatConverter
     */
    private $formatConverter;

    public function __construct() {
        $this->formatConverter = new MomentFormatConverter();
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options) {
        $view->vars['attr']['data-date-format'] = $this->formatConverter->convert($options['format']);
        ;
        $view->vars['attr']['data-date-locale'] = \Locale::getDefault();
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'widget' => 'single_text',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent() {
        return 'Symfony\Component\Form\Extension\Core\Type\DateTimeType';
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'datetime';
    }
}
