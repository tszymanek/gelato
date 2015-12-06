<?php

namespace Szymanek\Bundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GelatoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description', 'textarea')
            ->add('image', new ImageType(), array(
                'label' => false,
                'required' => false
            ))
//            ->add('list', 'entity', array(
//                'class' => 'TodaysGelatoBundle:Image',
//                'choice_label' => 'path',
//                'empty_data' => null,
//                'required' => false,
//                'placeholder' => ''
//            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Szymanek\Bundle\Entity\Gelato'
        ));
    }

    public function getName()
    {
        return 'gelato';
    }
}