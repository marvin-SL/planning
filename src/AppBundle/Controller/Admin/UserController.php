<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;

class UserController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->findAll();

        return $this->render('AppBundle:Admin/User:index.html.twig', array(
            'users' => $users,
        ));
    }

    public function newAction(Request $request)
    {
        $entity = new User();

        $securityContext = $this->container->get('security.context');

        $form = $this->createForm(new UserType($securityContext), $entity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
              $encoder = $this->container->get('security.encoder_factory')->getEncoder($entity);
            $password = 'cmw';
            $entity->setPassword($encoder->encodePassword($password, $entity->getSalt()));
            $entity->setUsername($entity->getFirstName().'.'.$entity->getLastName());

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $message = $this->get('translator')->trans('user.create_success', array('%name%' => $entity->getUsername()), 'flashes');
            $this->get('session')->getFlashBag()->add('success', $message);

            return $this->redirect($this->generateUrl('admin_user_index'));
        }

        return $this->render('AppBundle:Admin/User:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        if (!$entity = $em->getRepository('AppBundle:User')->find($id)) {
            throw $this->createNotFoundException(sprintf('Unable to find user with id "%s"', $id));
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new UserType($this->container->get('security.context')), $entity);
        $editForm->handleRequest($request);

        $users = $em->getRepository('AppBundle:User')->findAll();

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $message = $this->get('translator')->trans('user.update_success', array(), 'flashes');
            $this->get('session')->getFlashBag()->add('success', $message);

            return $this->redirect($this->generateUrl('admin_user_index'));
        }

        return $this->render('AppBundle:Admin/User:edit.html.twig', array(
           'form' => $editForm->createView(),
           'delete_form' => $deleteForm->createView(),
           'entity' => $entity,
           'users' => $users,
        ));
    }

    /**
     * Creates a form to delete a User entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_subject_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'button.delete', 'translation_domain' => 'forms'))
            ->getForm();
    }
}
