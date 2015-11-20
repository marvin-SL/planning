<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Calendar;
use AppBundle\Entity\Event;
use AppBundle\Entity\Subject;
use AppBundle\Entity\Teacher;
use AppBundle\Entity\ClassRoom;
use AppBundle\Form\EventType;
use AppBundle\Form\CalendarType;
use AppBundle\Form\SubjectType;
use AppBundle\Form\TeacherType;
use AppBundle\Form\ClassRoomType;

class AdminController extends Controller
{
  public function indexAction(Request $request)
  {
      return $this->render('AppBundle:Admin:index.html.twig');
  }

 
  public function createSubjectAction(Request $request)
  {
      // replace this example code with whatever you need
      $subject = new Subject();

      $form = $this->createForm(new SubjectType(), $subject);

      $form->handleRequest($request);

      if ($form->isValid())
      {
        $em = $this->getDoctrine()->getManager();
        $em->persist($subject);
        $em->flush();
      }

      return $this->render('AppBundle:Admin:createSubject.html.twig', array(
         'form' => $form->createView(),
      ));

  }

  public function createTeacherAction(Request $request)
  {
      // replace this example code with whatever you need
      $teacher = new Teacher();

      $form = $this->createForm(new TeacherType(), $Teacher);

      $form->handleRequest($request);

      if ($form->isValid())
      {
        $em = $this->getDoctrine()->getManager();
        $em->persist($teacher);
        $em->flush();
      }

      return $this->render('AppBundle:Admin:createTeacher.html.twig', array(
         'form' => $form->createView(),
      ));

  }

  public function createClassRoomAction(Request $request)
  {
      // replace this example code with whatever you need
      $clasRoom = new Subject();

      $form = $this->createForm(new ClassRoomType(), $classRoom);

      $form->handleRequest($request);

      if ($form->isValid())
      {
        $em = $this->getDoctrine()->getManager();
        $em->persist($classRoom);
        $em->flush();
      }

      return $this->render('AppBundle:Admin:createClassRoom.html.twig', array(
         'form' => $form->createView(),
      ));

  }



}
