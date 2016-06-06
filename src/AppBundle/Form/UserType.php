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
 * UserType.
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
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email', array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
            ->add('firstname', 'text', array('label' => 'Prénom'))
            ->add('lastname', 'text', array('label' => 'Nom'))
            ->add('save', 'submit', array('label' => 'button.create', 'translation_domain' => 'forms'))
            ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            if ($this->securityContext->isGranted('ROLE_SUPER_ADMIN')) {
                $form = $event->getForm();
                $this->addFieldsForSuperAdmin($form);
            } elseif ($this->securityContext->isGranted('ROLE_ADMIN')) {
                $form = $event->getForm();
                $this->addFieldsForAdmin($form);
            } elseif ($this->securityContext->isGranted('ROLE_EDITOR')) {
                $form = $event->getForm();
                $this->addFieldsForEditor($form);

            }
        });
    }

    /**
     * @param Form $form
     */
    private function addFieldsForSuperAdmin(Form $form)
    {
        $form->add('roles', 'choice', array(
            'label' => 'Rôles',
            'choices' => array(
                'ROLE_EDITOR' => 'Editeur',
                'ROLE_ADMIN' => 'Administrateur',
                'ROLE_SUPER_ADMIN' => 'Black Ninja'
            ),
            'multiple' => true,
        ));
    }

    /**
     * @param Form $form
     */
    private function addFieldsForAdmin(Form $form)
    {
        $form->add('roles', 'choice', array(
            'label' => 'Rôles',
            'choices' => array(
                'ROLE_EDITOR' => 'Editeur',
                'ROLE_ADMIN' => 'Administrateur',
            ),
            'multiple' => true,
        ));
    }

    /**
     * @param Form $form
     */
    private function addFieldsForEditor(Form $form)
    {
        $form->add('roles', 'choice', array(
            'choices' => array(
                'ROLE_EDITOR' => 'Editeur',
            ),
            'multiple' => true,
        ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
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
