<?php

namespace Trsteel\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PostType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('is_enabled', null, array(
                'required'  => false,
                'label'     => 'Enabled?'
            ))
            ->add('date')
            ->add('category', 'entity', array(
                'class'     => 'Trsteel\\BlogBundle\\Entity\\Category',
                'multiple'  => true,
                'expanded'  => true,
                'property'  => 'title',
            ))
            ->add('title')
            ->add('body', 'ckeditor')
        ;
    }

    public function getName()
    {
        return 'trsteel_blogbundle_posttype';
    }
}
