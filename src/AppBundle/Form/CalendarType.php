<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\Bundle\DoctrineBundle\Form\EntityType;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Repository\CalendarRepository;

class CalendarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('title', 'text', array('label' => 'Titre :'))
        ->add('save', 'submit', array('label' => 'button.create', 'translation_domain' => 'forms'))
        ->add('modele', 'entity', array(
              'class' => 'AppBundle:Calendar',
              'label' => 'Cloner un autre planning :',
              'empty_value' => 'input.calendar', 'translation_domain' => 'forms',
              'required'    => false,
              'query_builder' => function (EntityRepository $er) {
                  return $er->createQueryBuilder('c')
                      ->orderBy('c.title', 'ASC');
              },
              'choice_label' => function ($calendar) {
                  return $calendar->getTitle();
              },
            ))
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
        return 'app_calendar';
    }
}
