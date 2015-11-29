<?php

namespace Szymanek\Bundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MultipleImagesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('files', 'file', array(
                'multiple' => true,
                'attr' => array('accept' => 'image/*'),
                'label' => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Szymanek\Bundle\Entity\MultipleImages'
        ));
    }

    public function getName()
    {
        return 'multipleImages';
    }
}