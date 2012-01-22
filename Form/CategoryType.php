<?php

namespace Trsteel\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title')
        ;
    }

    public function getName()
    {
        return 'trsteel_blogbundle_categorytype';
    }
}
