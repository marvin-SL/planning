<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class MailingController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:Admin/Mailing:index.html.twig', array(

        ));
    }

    public function newAction(Request $request)
    {
        $calendar = new Calendar();

        $form = $this->createForm(new CalendarType(), $calendar);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($calendar);
            $em->flush();

            $serializer->serialize($calendar);

            $message = $this->get('translator')->trans('calendar.create_success', array(), 'flashes');
            $this->get('session')->getFlashBag()->add('success', $message);

            return $this->redirect($this->generateUrl('admin_calendar_index'));
        }

        return $this->render('AppBundle:Admin/Calendar:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
