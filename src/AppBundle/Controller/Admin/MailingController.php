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
            'mailingLists' => $mailingLists,
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

    public function editAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        if (!$entity = $em->getRepository('AppBundle:Mailing')->findOneBy(array('slug' => $slug))) {
            throw $this->createNotFoundException(sprintf('Unable to find mailing list with slug "%s"', $slug));
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

    public function writeMailAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $list = $em->getRepository('AppBundle:Mailing')->findOneBy(array('slug'=>$slug));

        return $this->render('AppBundle:Admin/Mailing:writeMail.html.twig', array(
            'list' => $list,
        ));
    }

    /**
     * Get preview from markdown.
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

        if (!$recipients = $em->getRepository('AppBundle:Mailing')->findByName($recipients)) {
            throw $this->createNotFoundException(sprintf('Unable to find mailing list "%s"', $recipients));
        };

        foreach ($recipients as $recipient) {
            $notificationManager->send($object, $body, 'sender@test.com', explode(';', $recipient->getMails()));
        }

        $message = $this->get('translator')->trans('mailing.send_success', array(), 'flashes');
        $this->get('session')->getFlashBag()->add('success', $message);

        return $this->redirect($this->generateUrl('admin_mailing_index'));
    }
}
