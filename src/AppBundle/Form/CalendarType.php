<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalendarType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('title', 'text', array('label' => 'Titre'))
        ->add('events', 'collection', array('type' => new EventType()))
        ->add('save','submit', array('label' =>'Créer'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Calendar',
        ));
    }

    public function getName()
   {
     
   }
}
