<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeacherType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('firstname', 'text', array('label' => 'Prénom'))
        ->add('lastname', 'text', array('label' => 'Nom'))
        ->add('save', 'submit', array('label' => 'button.create', 'translation_domain' => 'forms'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Teacher',
        ));
    }

    public function getName()
    {
        return 'app_teacher';
    }
}
