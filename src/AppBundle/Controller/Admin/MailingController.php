<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Mailing;
use AppBundle\Form\MailingType;

class MailingController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $mailingLists = $em->getRepository('AppBundle:Mailing')->findAll();

        return $this->render('AppBundle:Admin/Mailing:index.html.twig', array(
            "mailingLists" => $mailingLists,
        ));
    }

    public function newAction(Request $request)
    {
        $mailing = new Mailing();

        $form = $this->createForm(new MailingType(), $mailing);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mailing);
            $em->flush();

            $message = $this->get('translator')->trans('mailing.create_success', array(), 'flashes');
            $this->get('session')->getFlashBag()->add('success', $message);

            return $this->redirect($this->generateUrl('admin_mailing_index'));
        }

        return $this->render('AppBundle:Admin/Mailing:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        if (!$entity = $em->getRepository('AppBundle:Mailing')->findOneBy(array('id' => $id,))) {
            throw $this->createNotFoundException(sprintf('Unable to find mailing list with id "%s"', $id));
        };

        //$deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new MailingType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $message = $this->get('translator')->trans('mailing.update_success', array(), 'flashes');
            $this->get('session')->getFlashBag()->add('success', $message);

            return $this->redirect($this->generateUrl('admin_mailing_index'));
        }

        return $this->render('AppBundle:Admin/Mailing:edit.html.twig', array(
           'edit_form' => $editForm->createView(),
          // 'delete_form' => $deleteForm->createView(),
           'entity' => $entity,
        ));
    }

    public function writeMailAction($id)
    {
        //TODO: créer une forme pour saisir le texte du mail

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mailing);
            $em->flush();

            $message = $this->get('translator')->trans('mailing.create_success', array(), 'flashes');
            $this->get('session')->getFlashBag()->add('success', $message);

            return $this->redirect($this->generateUrl('admin_mailing_index'));
        }

        return $this->render('AppBundle:Admin/Mailing:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    public function sendAction($id)
    {
        return array();
    }
}
