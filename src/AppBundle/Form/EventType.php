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
        ->add('startDate','datetime', array(
                'input'  => 'datetime',
                'widget' => 'choice',
                'years'=> array('2015', '2016'),
                'label' => 'Début',
              ))

        ->add('endDate', 'datetime', array(
            'input'  => 'datetime',
            'widget' => 'choice',
            'years'=> array('2015', '2016'),
            'label' => 'Fin',
        ))

        ->add('calendar', 'entity', array(
              'class' => 'AppBundle:Calendar',
              'choice_label' => 'title',
              'label' => 'Calendrier :'
            ))
        ->add('subject', 'entity', array(
            'class' => 'AppBundle:Subject',
            'choice_label' => 'name',
            'label' => 'Matière :'
        ))
        ->add('classroom', 'entity', array(
            'class' => 'AppBundle:Classroom',
            'choice_label' => 'name',
            'label' => 'Salle/Bâtiment :'
        ))
        ->add('notice', 'text', array(
          'label' => 'Info :',
          'required' => false,
        ))
        ->add('save','submit', array('label' => 'button.create', 'translation_domain' => 'forms'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        // $resolver->setDefaults(array(
        //     'data_class' => 'AppBundle\Entity\Event',
        // ));
    }

    public function getName()
   {

   }
}
