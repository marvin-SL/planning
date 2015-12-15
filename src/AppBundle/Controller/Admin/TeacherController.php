<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Teacher;
use AppBundle\Form\TeacherType;

class TeacherController extends Controller
{

    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:Admin/Teacher:index.html.twig');
    }

    public function newAction(Request $request)
    {
        // replace this example code with whatever you need
        $teacher = new Teacher();

        $form = $this->createForm(new TeacherType(), $teacher);

        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($teacher);
            $em->flush();
        }

        return $this->render('AppBundle:Admin/Teacher:new.html.twig', array(
            'form' => $form->createView(),
        ));

    }
}
