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
        ->add('startDate', 'collot_datetime', array(
            'label' => 'Début :',
            'pickerOptions' => array('format' => 'dd/mm/yyyy hh:ii',
            'calendarWeeks' => true,
                'weekStart' => 0,
                'daysOfWeekDisabled' => '0,6', //example
                'autoclose' => true,
                'startView' => 'month',
                'minView' => 'hour',
                'maxView' => 'year',
                'todayBtn' => true,
                'todayHighlight' => true,
                'keyboardNavigation' => true,
                'language' => 'fr',
                'forceParse' => true,
                'minuteStep' => 30,
                'pickerReferer ' => 'default', //deprecated
                'pickerPosition' => 'bottom-right',
                'viewSelect' => 'hour',
                'showMeridian' => false,
                'starDate' => date('m/d/Y'),
                ), ))
        ->add('endDate', 'collot_datetime', array(
            'label' => 'Fin :',
            'pickerOptions' => array('format' => 'dd/mm/yyyy hh:ii',
                'weekStart' => 0,
                'daysOfWeekDisabled' => '0,6', //example
                'autoclose' => true,
                'startView' => 'month',
                'minView' => 'hour',
                'maxView' => 'year',
                'todayBtn' => true,
                'todayHighlight' => true,
                'keyboardNavigation' => true,
                'language' => 'fr',
                'forceParse' => true,
                'minuteStep' => 30,
                'pickerReferer ' => 'default', //deprecated
                'pickerPosition' => 'bottom-right',
                'viewSelect' => 'hour',
                'showMeridian' => false,
                'initialDate' => date('m/d/Y', 1577836800), //example
            ),
            ))

        ->add('calendar', 'entity', array(
              'class' => 'AppBundle:Calendar',
              'choice_label' => 'title',
              'label' => 'Calendrier :',
            ))
        ->add('subject', 'entity', array(
            'class' => 'AppBundle:Subject',
            'choice_label' => 'name',
            'label' => 'Matière :',
        ))
        ->add('classroom', 'entity', array(
            'class' => 'AppBundle:Classroom',
            'choice_label' => 'name',
            'label' => 'Salle/Bâtiment :',
        ))
        ->add('notice', 'text', array(
          'label' => 'Information complémentaire :',
          'required' => false,
        ))
        ->add('save', 'submit', array('label' => 'button.create', 'translation_domain' => 'forms'))
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
        return 'app_subject';
    }
}
