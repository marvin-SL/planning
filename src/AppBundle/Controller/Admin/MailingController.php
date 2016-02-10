<?php
/**
* AccountController Doc Comment
*
* PHP version 5.5.9
*
* @author Sainte-Luce Marvin <marvin.sainteluce@gmail.com>
* @link   https://github.com/marvin-SL/planning
*
*/

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Mailing;
use AppBundle\Form\MailingType;

class MailingController extends Controller
{
    /**
    * Show all Mailing entities
    * @param  Request $request [description]
    * @return [type]           [description]
    */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $mailingLists = $em->getRepository('AppBundle:Mailing')->findAll();

        return $this->render('AppBundle:Admin/Mailing:index.html.twig', array(
            'mailingLists' => $mailingLists,
        ));
    }

    /**
    * Add a new Mailing entity
    * @param  Request $request [description]
    * @return [type]           [description]
    */
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

    /**
    * Edit a Mailing entity by slug
    * @param  Request $request [description]
    * @param  [type]  $slug    [description]
    * @return [type]           [description]
    */
    public function editAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        if (!$entity = $em->getRepository('AppBundle:Mailing')->findOneBy(array('slug' => $slug))) {
            throw $this->createNotFoundException(sprintf('Unable to find mailing list with slug "%s"', $slug));
        };

        $deleteForm = $this->createDeleteForm($slug);
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
            'delete_form' => $deleteForm->createView(),
            'entity' => $entity,
        ));
    }

    /**
    * Generate a view to send an email by Mailing entity's slug
    * @param  [type] $slug [description]
    * @return [type]       [description]
    */
    public function writeMailAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $list = $em->getRepository('AppBundle:Mailing')->findOneBy(array('slug'=>$slug));

        return $this->render('AppBundle:Admin/Mailing:writeMail.html.twig', array(
            'list' => $list,
        ));
    }

    /**
    * Send an mail
    *
    * @param string $subject
    * @param string $recipient
    * @param string $report
    * @param string $comment
    */
    public function sendAction(Request $request)
    {
        $notificationManager = $this->get('app.manager.notification');
        $em = $this->getDoctrine()->getManager();

        $object = $request->request->get('object');
        $recipients =  $request->request->get('recipient');

        $body = $this->renderView(
        'AppBundle:Admin/Notification:notification.html.twig',
        array(
            'comment' => $request->request->get('comment'),
            'text/html', )
        );

        if (!$recipients = $em->getRepository('AppBundle:Mailing')->findOneBy(array("name" => $recipients))) {
            throw $this->createNotFoundException(sprintf('Unable to find mailing list "%s"', $recipients));
        };

        foreach ($recipients as $recipient) {
            $notificationManager->send($object, $body, 'sender@test.com', explode(';', $recipient->getMails()));
        }
        
        $recipients->setSentAt(new \DateTime("now"));
        $em->persist($recipients);
        $em->flush();

        $message = $this->get('translator')->trans('mailing.send_success', array(), 'flashes');
        $this->get('session')->getFlashBag()->add('success', $message);

        return $this->redirect($this->generateUrl('admin_mailing_index'));
    }

    /**
    * Deletes a Mailing entity by id
    *
    * @param Request $request
    * @param int     $id
    *
    * @return Symfony\Component\HttpFoundation\Response
    */
    public function deleteAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createDeleteForm($slug);

        if ($form->handleRequest($request)->isValid()) {
            if (!$entity = $em->getRepository('AppBundle:Mailing')->findOneBy(array('slug' => $slug))) {
                throw $this->createNotFoundException('Unable to find Mailing entity.');
            }

            $em->remove($entity);
            $em->flush();

            $message = $this->get('translator')->trans('mailing.delete_success', array(), 'flashes');
            $this->get('session')->getFlashBag()->add('success', $message);
        }

        return $this->redirect($this->generateUrl('admin_mailing_index'));
    }

    /**
    * Creates a form to delete a Mailing entity by id.
    *
    * @param mixed $id The entity id
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createDeleteForm($slug)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('admin_mailing_delete', array('slug' => $slug)))
        ->setMethod('DELETE')
        ->add('submit', 'submit', array('label' => 'button.delete', 'translation_domain' => 'forms'))
        ->getForm();
    }
}
