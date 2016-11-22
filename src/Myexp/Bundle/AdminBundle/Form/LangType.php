<?php

namespace Myexp\Bundle\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LangType extends AbstractType {

    private $languageChoices;

    public function __construct(array $languageChoices) {
        $this->languageChoices = $languageChoices;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'choices' => $this->languageChoices
        ));
    }

    public function getParent() {
        return 'choice';
    }

    public function getName() {
        return 'lang';
    }

}