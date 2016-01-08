<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use AppBundle\Form\ChangePasswordFormType;


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

    public function changePasswordAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('app.change_password');

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_profile_show');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('AppBundle:ChangePassword:changePassword.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
