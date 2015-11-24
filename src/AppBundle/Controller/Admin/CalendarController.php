<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Calendar;
use AppBundle\Form\CalendarType;
use AppBundle\Entity\ClassRoom;
use AppBundle\Form\ClassRoomType;

class CalendarController extends Controller
{

    public function newAction(Request $request)
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

        return $this->render('AppBundle:Admin/Calendar:new.html.twig', array(
            'form' => $form->createView(),
        ));

    }

    public function showAction(Request $request)
    {
        $entity = new ClassRoom();
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:ClassRoom');

        $item= $repository->findAll();

        $form = $this->createForm(new ClassRoomType(), $entity);

        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
        }
        return $this->render('AppBundle:Admin/Calendar:show.html.twig', array(
            'item' => $item,
        ));
    }

}
