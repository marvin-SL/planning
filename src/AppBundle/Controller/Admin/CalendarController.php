<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Calendar;
use AppBundle\Entity\ClassRoom;
use AppBundle\Entity\Teacher;
use AppBundle\Entity\Subject;



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

        $teachers = new Teacher();
        $subjects = new Subject();
        $classRooms = new ClassRoom();

        $teacherRepository = $this->getDoctrine()
        ->getRepository('AppBundle:Teacher');

        $subjectRepository = $this->getDoctrine()
        ->getRepository('AppBundle:Subject');

        $classRoomRepository = $this->getDoctrine()
            ->getRepository('AppBundle:ClassRoom');

        $teacherNode = $teacherRepository->findAll();
        $subjectNode = $subjectRepository->findAll();
        $classRoomNode = $classRoomRepository->findAll();

        // $form = $this->createForm(new EventType(), $entity);
        //
        // $form->handleRequest($request);
        //
        // if ($form->isValid())
        // {
        //     $em = $this->getDoctrine()->getManager();
        //     $em->persist($event);
        //     $em->flush();
        // }
        return $this->render('AppBundle:Admin/Calendar:show.html.twig', array(
            'teacherNode' => $teacherNode,
            'subjectNode' => $subjectNode,
            'classRoomNode' => $classRoomNode,
        ));
    }

}
