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
        return $this->render('AppBundle:Admin/Mailing:index.html.twig', array(

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
}
