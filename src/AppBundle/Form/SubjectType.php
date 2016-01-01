<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Oh\ColorPickerTypeBundle\Form\Type\ColorPickerType;

class SubjectType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', 'text', array('label' => 'Nom matière'))
        ->add('teachers', 'entity', array(
              'class' => 'AppBundle:Teacher',
              'choice_label' => 'lastname',
              'label' => 'Enseignant',
              'multiple'    => true,
              'label' => 'Enseignant(e)s / Intervenant(e)s'
            ))
        ->add('color', 'text', array('label' => 'Couleur'))
        ->add('save', 'submit', array('label' => 'Créer'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Subject',
        ));
    }

    public function getName()
   {

   }
}
