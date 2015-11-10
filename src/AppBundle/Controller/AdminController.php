<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Calendar;
use AppBundle\Entity\Event;
use AppBundle\Form\EventType;

class AdminController extends Controller
{
  public function indexAction(Request $request)
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

      return $this->render('AppBundle:Admin:index.html.twig', array(
         'form' => $form->createView(),
      ));
  }

}
