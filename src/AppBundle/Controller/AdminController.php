<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Calendar;
use AppBundle\Entity\Event;
use AppBundle\Form\EventType;
use AppBundle\Form\CalendarType;

class AdminController extends Controller
{
  public function indexAction(Request $request)
  {
      return $this->render('AppBundle:Admin:index.html.twig');
  }

  public function createCalendarAction(Request $request)
  {
    // replace this example code with whatever you need
    $calendar = new Calendar();

    $form = $this->createForm(new CalendarType(), $calendar);

    $form->handleRequest($request);

    if ($form->isValid())
    {
      $em = $this->getDoctrine()->getManager();
      $em->persist($calendar);
      $em->flush();
    }

    return $this->render('AppBundle:Admin:createCalendar.html.twig', array(
       'form' => $form->createView(),
    ));

  }

  public function createEventAction(Request $request)
  {
      // replace this example code with whatever you need
      $event = new Event();

      $form = $this->createForm(new EventType(), $event);

      $form->handleRequest($request);

      if ($form->isValid())
      {
        $em = $this->getDoctrine()->getManager();
        $em->persist($event);
        $em->flush();
      }

      return $this->render('AppBundle:Admin:createEvent.html.twig', array(
         'form' => $form->createView(),
      ));

  }

}
