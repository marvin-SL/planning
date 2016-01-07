<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
           // 3) Encode the password (you could also do this via Doctrine listener)
          $encoder = $this->container->get('security.encoder_factory')->getEncoder($entity);
          $password = 'cmw';
          $entity->setPassword($encoder->encodePassword($password, $entity->getSalt()));
          $entity->setUsername($entity->getFirstName().".".$entity->getLastName());

           // 4) save the User!
           $em = $this->getDoctrine()->getManager();
           $em->persist($entity);
           $em->flush();

           $message = $this->get('translator')->trans('user.create_success', array('%name%' => $entity->getUsername()), 'flashes');
           $this->get('session')->getFlashBag()->add('success', $message);

           return $this->redirect($this->generateUrl('admin_user_index'));
       }

        return $this->render('AppBundle:Admin/User:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    public function showAction($username)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:User')->findOneByUsername($username);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $breadcrumbs->addRouteItem($entity->getUsername(), "admin_user_show", array('username' => $username));
        //$deleteForm = $this->createDeleteForm($username);

        return $this->render('AppBundle:Admin/User:show.html.twig', array(
            'entity'      => $entity,
            //'delete_form' => $deleteForm->createView(),
        ));
    }
}
