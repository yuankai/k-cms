<?php

namespace Myexp\Bundle\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\Common\Persistence\ObjectManager;

use Myexp\Bundle\AdminBundle\Form\Type\EntityIdType;
use Myexp\Bundle\AdminBundle\EventListener\UrlAliasFormSubscriber;

class CategoryType extends AbstractType {
    
    /**
     *
     * @var type 
     */
    private $manager;
    
    /**
     * 
     * @param ObjectManager $manager
     */
    public function __construct(ObjectManager $manager) {
        $this->manager = $manager;
    }

    /**
     * 
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        //url别名监听器
        $builder->addEventSubscriber(new UrlAliasFormSubscriber($this->manager, 'list'));
        
        $builder
                ->add('title', TextType::class, array(
                    'label' => 'category.title',
                    'attr' => array('size' => 80)
                ))
                ->add('keywords', TextType::class, array(
                    'label' => 'category.keywords',
                    'required' => false,
                    'attr' => array('size' => 80)
                ))
                ->add('urlAlias', EntityIdType::class, array(
                    'class' => 'MyexpAdminBundle:UrlAlias',
                    'required' => false
                ))
                ->add('urlAliasUrl', TextType::class, array(
                    'label' => 'content.url_alias',
                    'invalid_message' => 'Url alias existed!',
                    'mapped' => false,
                    'required' => false
                ))
                ->add('sequenceId', IntegerType::class, array(
                    'label' => 'category.sequence_id',
                    'required' => false,
                    'attr' => array('class' => 'number')
                ))
                ->add('isActive', CheckboxType::class, array(
                    'label' => 'category.is_active',
                    'required' => false
                ))
                ->add('parent', EntityIdType::class, array(
                    'class' => 'MyexpAdminBundle:Category',
                    'required' => false
                ))
                ->add('website', EntityIdType::class, array(
                    'class' => 'MyexpAdminBundle:Website',
                    'required' => true
                ))
                ->add('contentModel', EntityIdType::class, array(
                    'class' => 'MyexpAdminBundle:ContentModel',
                    'required' => true
                ))
        ;
    }

    /**
     * 默认配置
     * 
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Myexp\Bundle\AdminBundle\Entity\Category'
        ));
    }

}
