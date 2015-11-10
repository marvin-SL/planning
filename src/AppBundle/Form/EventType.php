<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('title', 'text', array('label' => 'Titre'))
        
        ->add('start','datetime', array(
                'input'  => 'datetime',
                'widget' => 'choice',
                'years'=> array('2015', '2016'),
                'label' => 'Début',
              ))

        ->add('end', 'datetime', array(
            'input'  => 'datetime',
            'widget' => 'choice',
            'years'=> array('2015', '2016'),
            'label' => 'Fin',
        ))

        ->add('calendar', 'entity', array(
              'class' => 'AppBundle:Calendar',
              'choice_label' => 'title'))
        ->add('save','submit', array('label' =>'Créer'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Event',
        ));
    }

    public function getName()
   {

   }
}
