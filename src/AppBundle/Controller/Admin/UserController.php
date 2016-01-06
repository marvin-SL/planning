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

    public function createAction(Request $request)
    {
        $entity = new User();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $entity->setUsername(stristr($entity->getEmail(), '@', true));

            $encoder = $this->container->get('security.encoder_factory')->getEncoder($entity);
            $tokenGenerator = $this->get('fos_user.util.token_generator');
            //$password = substr($tokenGenerator->generateToken(), 0, 16);
            $password = 'cmw';

            $entity->setPassword($encoder->encodePassword($password, $entity->getSalt()));
            if (null === $entity->getConfirmationToken()) {
                /** @var $tokenGenerator \FOS\UserBundle\Util\TokenGeneratorInterface */
                $tokenGenerator = $this->get('fos_user.util.token_generator');
                $entity->setConfirmationToken($tokenGenerator->generateToken());
            }

            $this->get('fos_user.mailer')->sendResettingEmailMessage($entity);
            $entity->setPasswordRequestedAt(new \DateTime());

            $this->get('fos_user.user_manager')->updateUser($entity);

            $em->persist($entity);
            $em->flush();

            $message = $this->get('translator')->trans('user.create_success', array('%name%' => $entity->getUsername()), 'flashes');
            $this->get('session')->getFlashBag()->add('success', $message);

            return $this->redirect($this->generateUrl('admin_user_show', array('username' => $entity->getUsername())));
        }

        return $this->render('AppBundle:Admin/User:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    private function createCreateForm(User $entity)
    {
        $securityContext = $this->container->get('security.context');
        $form = $this->createForm(new UserType($securityContext), $entity, array(
            'action' => $this->generateUrl('admin_user_create'),
            'method' => 'POST',
        ));

        $form->add('save', 'submit', array('label' => 'button.create', 'translation_domain' => 'forms'));

        return $form;
    }

    public function newAction()
    {
        $entity = new User();
        $form   = $this->createCreateForm($entity);

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
