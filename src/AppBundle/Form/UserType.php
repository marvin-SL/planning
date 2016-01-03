<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * UserType
 */
class UserType extends AbstractType
{
    /**
     * @var SecurityContext
     */
    private $securityContext;

    /**
     * @param SecurityContext $securityContext
     */
    public function __construct(SecurityContext $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * @param FormBuilderInterface  $builder
     * @param array                 $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email', array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
            ->add('firstname', 'text', array('label' => 'Prénom'))
            ->add('lastname', 'text', array('label' => 'Nom'))
            ->add('jobTitle', 'text', array(
                'label' => 'Fonction',
                'required' => false
            ))
            ->add('department', 'text', array(
                'label' => 'Département',
                'required' => false
            ))
            ->add('customer', 'entity', array(
                'class' => 'AppBundle:Customer',
                'property' => 'name',
                'label'=> 'Choix du client'
            ));
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
            if ($this->securityContext->isGranted('ROLE_SUPER_ADMIN')) {
                $form = $event->getForm();
                $this->addFieldsForSuperadmin($form);

            } else if ($this->securityContext->isGranted('ROLE_ADMIN')) {
                $form = $event->getForm();
                $this->addFieldsForAdmin($form);
            }
        });
    }

    /**
     * @param Form $form
     */
    private function addFieldsForSuperadmin(Form $form)
    {
        $form->add('username', 'text', array(
            'required' => false
        ));
        $form->add('roles', 'choice', array(
            'label' => 'Rôles',
            'choices' => array(
                'ROLE_USER' => 'Utilisateur',
                'ROLE_MANAGER' => 'Manager',
                'ROLE_ADMIN' => 'Administrateur',
                'ROLE_SUPER_ADMIN' => 'Super administrateur'
            ),
            'multiple' => true
        ));
        $form->add('enabled', 'checkbox', array(
            'label' => 'Actif',
            'attr'     => array('checked'   => 'checked'),
            'required' => false,
        ));
    }

    /**
     * @param Form $form
     */
    private function addFieldsForAdmin(Form $form)
    {
        $form->add('roles', 'choice', array(
            'choices' => array(
                'ROLE_USER' => 'Utilisateur',
                'ROLE_MANAGER' => 'Manager'
            ),
            'multiple' => true
        ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_user';
    }
}
